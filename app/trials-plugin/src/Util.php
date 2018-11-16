<?php

use WHMCS\Database\Capsule;

class Util {

    // store default price if price is overridden

    static $defaultPrices = [];

    static $trialPrice = null;

    public static function setDefaultPrice($pid, $price) {
        self::$defaultPrices[$pid] = $price;
    }

    public static function getDefaultPrice($pid) {
        return isset(self::$defaultPrices[$pid]) ? self::$defaultPrices[$pid] : false;
    }

    public static function getTrialProductPrice() {
        if (self::$trialPrice === null) {
            self::$trialPrice = (float) Capsule::table('tbladdonmodules')->where('module', 'trial_products')
                ->where('setting', 'trialprice')->value('value');

            if(is_null(self::$trialPrice))
                self::$trialPrice = 0;
        }

        return self::$trialPrice;
    }

    // check if trial allowed and store reason if not to pass beetween hooks

    static $trialNotAllowedReason = [];

    const EXIST_TRIAL_PRODUCT = 1;
    const PPBA_NOT_SET = 2;
    const EXIST_TRIAL_ON_SAME_PPBA_EMAIL = 3;

    static $reasonCodesMap = [
        self::EXIST_TRIAL_PRODUCT => 'Exist trial product',
        self::EXIST_TRIAL_ON_SAME_PPBA_EMAIL => 'Exist trial product',
        self::PPBA_NOT_SET => 'PPBA not set'
    ];

    public static function checkIfTrialPurchaseAllowedForProducts($clientId, $pids)
    {
        $join = '';
        $notAllowedReason = '""';
        $params = [];

        if ($clientId) {
            $bid = Capsule::table('mod_paypalbilling')
                ->where('id', $clientId)
                ->where('agreement_status', 'active')
                ->value('paypalbillingid');

            $params = [$clientId];
            $join = 'LEFT JOIN tblhosting h_by_id ON h_by_id.id = ? AND h_by_id.packageid = p.id';
            $notAllowedReason = 'CASE WHEN h_by_id.id THEN "' . self::$reasonCodesMap[self::EXIST_TRIAL_PRODUCT] . '"';

            if ($bid) {
                $emailId = self::getPayerPPEmailId($bid);
                $join .= "\nLEFT JOIN tblhosting h_by_emailid ON h_by_emailid.payeremailid = ? AND h_by_emailid.packageid = p.id";
                $notAllowedReason .= "\nWHEN h_by_emailid.id THEN \"" . self::$reasonCodesMap[self::EXIST_TRIAL_ON_SAME_PPBA_EMAIL] . '"';
                $notAllowedReason .= "\nELSE '' END";
                $params[] = $emailId;
            } else {
                $notAllowedReason .= "\nELSE \"" . self::$reasonCodesMap[self::PPBA_NOT_SET] . '" END';
            }
        }

        $sql = "
            SELECT
                p.id,
                if(cf.id, 1, 0) as trial,
                $notAllowedReason as reasonNotAllowed
            FROM tblproducts p
            LEFT JOIN tblcustomfields cf ON cf.relid = p.id AND cf.fieldname = 'trial_off' AND cf.fieldoptions = '0'
            $join
            WHERE p.id IN (" . implode($pids, ',') . ")
        ";

        return Capsule::connection()->select($sql, $params);
    }

    public static function trialPurchaseAllowed($clientId, $pid) {
        if(empty($clientId)) {
            self::$trialNotAllowedReason[$pid] = self::PPBA_NOT_SET;
            return false;
        }

        if(!empty(Capsule::table('tblhosting')->where('userid', $clientId)->where('packageid', $pid)->where('is_trial', 1)->first())) {
            self::$trialNotAllowedReason[$pid] = self::EXIST_TRIAL_PRODUCT;
        } else if (!($bid = Capsule::table('mod_paypalbilling')->where('id', $clientId)
            ->where('agreement_status', 'active')->value('paypalbillingid'))) {
            self::$trialNotAllowedReason[$pid] = self::PPBA_NOT_SET;
        } else if ($emailId = self::getPayerPPEmailId($bid)) {
            if(!is_null(Capsule::table('tblhosting')->where('packageid', $pid)
                ->where('is_trial', 1)->where('payeremailid', $emailId)->first())) {
                self::$trialNotAllowedReason[$pid] = self::EXIST_TRIAL_ON_SAME_PPBA_EMAIL;
            } else
                return true;
        } else {
            logActivity('### Trial Products: Failed to extract payer email from IPN, clientId - #' . $clientId . ', PPBA id - ' . $bid);
        }

        return false;
    }

    public static function checkIfProductIsTrial($pid) {
        return !!Capsule::connection()->selectOne(
            'SELECT
              cf.relid
            FROM tblcustomfields cf JOIN tblcustomfields cf2 ON cf.relid = cf2.relid
              AND cf2.fieldname = \'free_period\'
            WHERE cf.fieldname = \'trial_off\' AND cf.fieldoptions = 0 AND cf.relid = ?', [$pid]);
    }

    public static function getTrialsNotAllowedReasons() {
        return self::$trialNotAllowedReason;
    }

    public static function getTrialNotAllowedReason($pid) {
        if(!isset(self::$trialNotAllowedReason[$pid]))
            return '';

        if(self::$trialNotAllowedReason[$pid] == self::PPBA_NOT_SET)
            return 'PPBA not set';
        else if(self::$trialNotAllowedReason[$pid] == self::EXIST_TRIAL_PRODUCT || self::$trialNotAllowedReason[$pid] == self::EXIST_TRIAL_ON_SAME_PPBA_EMAIL)
            return 'Exist trial product';

        return '';
    }

    public static function getPayerPPEmailId($bid) {
        if($id = Capsule::table('tbltrialproductsppbaemail')->where('paypalbillingid', $bid)->value('emailid')) {
            return $id;
        } else {
            $res = Capsule::connection()->selectOne(
                'SELECT * FROM `tblgatewaylog`
                WHERE `gateway` IN (\'MyWorks Paypal Billing Module\', \'PayPal Billing Agreement\')
                  AND `result` = \'Notify\'
                  AND `data` LIKE \'%mp_id => ' . $bid . '%\'');

            if (!$res) {
                logActivity('### TrialProducts: cannot find ipn associated with creation of billing agreement ' . $bid);
            }

            $matches = [];
            preg_match('/payer_email\s+=>\s+(\S*)/', $res->data, $matches);

            if(!isset($matches[1])) {
                logActivity('### TrialProducts: no \'payer_email\' in ipn #' . $res['id']);
                return 0;
            }

            $email = $matches[1];

            if(!($id = Capsule::table('tbltrialproductsemailpayers')->where('payeremail', $email)->value('id'))) {
                $id = Capsule::table('tbltrialproductsemailpayers')->insertGetId(['payeremail' => $email]);
            }

            Capsule::table('tbltrialproductsppbaemail')->insert(['emailid' => $id, 'paypalbillingid' => $bid]);

            return $id;
        }
    }

    public static function getBaseUrl() {
        return Capsule::table('tblconfiguration')->where('setting', 'SystemURL')->value('value');
    }

    public static function isTrialNotEnded($serviceId) {
        $pid = Capsule::table('tblhosting')->where('id', $serviceId)->value('packageid');

        if(!($freePeriod = self::trialProductsGetFreePeriod($pid, $serviceId))) {
            return false;
        }

        $res = Capsule::connection()->selectOne(
            'SELECT (SELECT COUNT(*) FROM tblinvoices inv
          JOIN tblinvoiceitems ii ON ii.invoiceid = inv.id and ii.type = \'Hosting\'
          AND ii.relid = ? WHERE `status` = \'Paid\') > 1 as invoice_paid
          FROM `tblhosting` WHERE `is_trial`=1 and tblhosting.id = ? and DATE_ADD(tblhosting.regdate, INTERVAL '. $freePeriod . ' DAY) = tblhosting.nextduedate', [$serviceId, $serviceId]);

        if($res && $res->invoice_paid == 0)
            return true;

        return false;
    }

    // Proxy upgrade in trial period

    static $backup = [];

    public static function setDueDateAndRecurAmountForFullPriceUpgrade($serviceId) {
        $hosting = Capsule::connection()->table('tblhosting')->where('id', $serviceId)->first();
        self::$backup[$serviceId] = ['nextduedate' => $hosting->nextduedate, 'amount' => $hosting->amount];

        Capsule::connection()->update('UPDATE `tblhosting` SET `nextduedate` = DATE_ADD(curdate(), INTERVAL 1 MONTH), `amount` = 0 WHERE `id` = ?', [$serviceId]);
    }

    public static function restoreDueDateAndRecurAmount($serviceId) {
        if(isset(self::$backup[$serviceId]) && Capsule::connection()->table('tblhosting')->where('id', $serviceId)->update([
            'nextduedate' => self::$backup[$serviceId]['nextduedate'],
            'amount' => self::$backup[$serviceId]['amount']
        ])) {
            return self::$backup[$serviceId]['amount'];
        }

        return false;
    }

    public static function trialProductsGetFreePeriod($productId, $serviceId) { //!
        $res = Capsule::connection()->selectOne(
            'SELECT cfv.value FROM tblcustomfields cf
            LEFT JOIN tblcustomfieldsvalues cfv ON cfv.fieldid = cf.id
            WHERE cf.relid = ? AND cfv.relid = ? AND cf.fieldname = \'free_period\'', [$productId, $serviceId]);

        if(empty($res)) {
            return 0;
        }

        return (int) $res->value;
    }

    public static function getClientEmailId($clientId) {
        if(!($bid = Capsule::table('mod_paypalbilling')->where('id', $clientId)
            ->where('agreement_status', 'active')->value('paypalbillingid')))
            return 0;

        if(!($emailId = self::getPayerPPEmailId($bid)))
            return 0;

        return $emailId;
    }

    public static function renderTemplate($file, array $vars = []) {
        global $templates_compiledir;
        /** @noinspection PhpUndefinedClassInspection */
        $smarty = new \Smarty();
        $smarty->compile_dir = $templates_compiledir;
        foreach ($vars as $key => $value) {
            $smarty->assign($key, $value);
        }
        // Render template
        $rendered = $smarty->fetch($file);
        return $rendered;
    }

    public static function removePromo($serviceId) {
        $removePromo = Capsule::table('tbladdonmodules')->where('module', 'trial_products')
            ->where('setting', 'removePromo')->value('value');

        if ($removePromo == 'on') {
            Capsule::connection()->table('tblhosting')
                ->where('id', $serviceId)
                ->update([
                    'promoid' => 0
                ]);

            Capsule::connection()->table('tblinvoiceitems')
                ->where('type', 'PromoHosting')
                ->where('relid', $serviceId)
                ->delete();
        }
    }
}
