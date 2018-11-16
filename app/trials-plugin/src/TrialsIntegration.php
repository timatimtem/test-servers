<?php
/**
 * Created by PhpStorm.
 * User: Illia
 * Date: 12.04.2018
 * Time: 21:48
 */

use WHMCS\Database\Capsule;

require_once 'Util.php';

class TrialsIntegration
{
    protected $deferredSetupEnabled = true;
    protected $processDeferredTrialSetup = false;

    public static function getInstance()
    {
        static $instance;
        if (!$instance) {
            $instance = new static();
        }

        return $instance;
    }

    public function preventDeferredTrialSetup()
    {
        $this->deferredSetupEnabled = false;
    }

    public function triggerPendingTrialProcessing()
    {
        $this->processDeferredTrialSetup = true;
    }

    public function isPendingTrial()
    {
        return $this->processDeferredTrialSetup;
    }

    public function onBlazingServersOrderCreated($userId, $serviceId)
    {
        $this->onProxyOrderCreated($userId, $serviceId);
    }

    public function onProxyOrderCreated($userId, $serviceId)
    {
        $dueDate = Capsule::table('tblhosting')->where('id', $serviceId)->value('nextduedate');

        if ($this->processDeferredTrialSetup) {
            Capsule::connection()->insert(
                'INSERT INTO `tblinvoiceitems`
                    (`invoiceid`, `userid`, `type`, `relid`, `description`, `amount`, `taxed`, `duedate`, `paymentmethod`)
                VALUES
                    (-1, ?, \'Hosting\', ?, \'Dummy invoice\', 0, 0, ?,\'paypal\')',
                [
                    $userId,
                    $serviceId,
                    $dueDate
                ]
            );

            Capsule::connection()->insert(
                'INSERT INTO `tbltrialproducts_peding_trials`
                    (`serviceid`, `userid`)
                VALUES (?, ?)', [$serviceId, $userId]
            );
        }
    }

    public function getTrialProducts()
    {
        $res = Capsule::connection()->select(
            'SELECT
              cf.relid,
              cf2.fieldoptions AS free_period
            FROM tblcustomfields cf JOIN tblcustomfields cf2 ON cf.relid = cf2.relid
              AND cf2.fieldname = \'free_period\'
            WHERE cf.fieldname = \'trial_off\' AND cf.fieldoptions = 0');

        $indexedResult = [];
        foreach ($res as $i => $item) {
            $indexedResult[$item->relid] = $item->free_period;
        }

        return $indexedResult;
    }

    public function isDeferredTrialSetupAvailable($clientId, $pid)
    {
        return ($this->deferredSetupEnabled
            && Util::checkIfProductIsTrial($pid)
            && !Util::trialPurchaseAllowed($clientId, $pid)
            && Util::getTrialsNotAllowedReasons()[$pid] === Util::PPBA_NOT_SET);
    }
}
