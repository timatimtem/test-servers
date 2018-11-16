<?php

namespace WHMCS\Module\Blazing\Servers\Controller;

use WHMCS\Module\Blazing\Servers\Events\TrialPricingOverrode;
use WHMCS\Module\Blazing\Servers\Vendor\Axelarge\ArrayTools\Arr;
use WHMCS\Module\Blazing\Servers\Vendor\Symfony\Component\HttpFoundation\Request;
use WHMCS\Module\Blazing\Servers\Logger;
use WHMCS\Module\Blazing\Servers\Vendor\WHMCS\Module\Framework\Addon;
use WHMCS\Module\Blazing\Servers\Vendor\WHMCS\Module\Framework\Helper;

class APIController extends AbstractSelfDrivenController
{
    public function getClientProductsAction($clientid, $limitstart = 0, $limitnum = 50)
    {
        $response = Helper::apiResponse('getClientsProducts', [
            'clientid' => $clientid,
            'limitstart' => $limitstart,
            'limitnum' => $limitnum
        ],'result=success');
        $response['products']['product'] = array_column($response['products']['product'], null, 'id');


        /** @noinspection PhpUndefinedFunctionInspection */
        $result = run_hook('GetTrialServices', [
            'userId' => $clientid
        ]);

        $trialServices = [];
        if (!isset($result[0])) {
            Logger::notice('Trials plugin is not reachable');
        } else {
            $trialServices = array_column($result[0], null, 'id');
        }

        foreach ($trialServices as $trialService) {
            if (isset($response['products']['product'][$trialService->id])) {
                $response['products']['product'][$trialService->id]['trialStatus'] = $trialService->status;
            }
        }

        return $response;
    }

    public function addOrderAction(Request $request)
    {
        if ($request->getMethod() !== 'POST') {
            throw new \ErrorException('Method not allowed: ' . $request->getMethod() . '. Allowed method \'POST\'');
        }

        $params = [
            'clientid' => $request->get('clientid'),
            'pid' => $request->get('pid'),
            'billingcycle' => $request->get('billingcycle'),
            'paymentmethod' => $request->get('paymentmethod'),
            'hostname' => $request->get('hostname'),
            'rootpw' => $request->get('rootpw'),
            'promocode' => $request->get('promocode', false)
        ];

        if($request->get('configoptions')) {
            $params['configoptions'] = $request->get('configoptions');
        }

        $customOptions = [
            'trial' => $request->get('trial', false)
        ];

        /** @noinspection PhpUndefinedFunctionInspection */
        $mergeParams = run_hook('BlazingServersBeforeOrderCreated', [
            'customOptions' => $customOptions,
            'billingCycle'  => $params['billingcycle'],
            'productId'     => $params['pid'],
            'userId'        => $params['clientid']
        ]);

        if(!is_array($mergeParams)) {
            $mergeParams = [[]];
        }

        TrialPricingOverrode::trackOverride();

        $response = Helper::apiResponse(
            'addOrder',
            array_merge($params, ...$mergeParams),
            'result=success');

        /** @noinspection PhpUndefinedFunctionInspection */
        run_hook('BlazingServersOrderCreated', [
            'customOptions' => $customOptions,
            'productId'     => $params['pid'],
            'userId'        => $params['clientid'],
            'serviceId'     => (int) $response['productids']
        ]);

        if (TrialPricingOverrode::isOverrode()) {
            $response['trial'] = true;
        } else {
            $response['trial'] = false;
            $response['pendingTrial'] = TrialPricingOverrode::isPendingTrial();
            if ($customOptions['trial']) {
                $response['trialNotAllowedReason'] = TrialPricingOverrode::getNotAllowedReason();
            }
        }

        return $response;
    }

    public function getProductsAction($pid = null, $gid = null, $clientid = null, $showhidden = false)
    {
        require_once ROOT_DIR . '/../../../includes/configoptionsfunctions.php';
        require_once ROOT_DIR . '/../../../includes/customfieldfunctions.php';

        $where = $showhidden ? '' : 'p.hidden = 0';
        $params = [];
        if ($gid) {
            $where .= ' AND p.gid = ?';
            $params[] = $gid;
        }

        if ($pid) {
            if (!is_array($pid)) {
                $pid = [$pid];
            }

            $where .= ' AND p.id IN (' . implode(',', $pid) . ')';
        }

        $products = Helper::conn()->select("
            SELECT * FROM tblproducts p
            WHERE $where
        ", $params);

        /** @noinspection PhpUndefinedFunctionInspection */
        $result = run_hook('CheckIfTrialPurchaseAllowedForProducts', [
            'userId' => $clientid,
            'pids' => array_column($products, 'id')
        ]);

        $trialInfo = [];
        if (!isset($result[0])) {
            Logger::notice('Trials plugin is not reachable');
        } else {
            $trialInfo = array_column($result[0], null, 'id');
        }

        foreach($products as &$product) {
            $configoptionData = [];
            /** @noinspection PhpUndefinedFunctionInspection */
            $configurableOptions = getCartConfigOptions($product['id'], "", "", "", true);
            foreach ($configurableOptions as $option) {
                $options = [];
                $optPricings = Arr::groupBy(Helper::conn()->select(
                    "SELECT
                            relid, code, msetupfee, qsetupfee, ssetupfee, asetupfee, bsetupfee, tsetupfee, monthly, quarterly, semiannually, annually, biennially, triennially
                    FROM tblpricing
                    INNER JOIN tblcurrencies ON tblcurrencies.id = tblpricing.currency
                    WHERE type = 'configoptions' AND relid IN (" . implode(',', array_column($option['options'], 'id')) . ")"
                ), 'relid');

                foreach ($option['options'] as $op) {
                    $pricing = [];

                    foreach ($optPricings[$op['id']] as $oppricing) {
                        $currcode = $oppricing['code'];
                        unset($oppricing['code']);
                        unset($oppricing['relid']);
                        $pricing[$currcode] = $oppricing;
                    }

                    $options['option'][] = array("id" => $op['id'], "name" => $op['name'], "recurring" => $op['recurring'], "pricing" => $pricing);
                }

                $configoptionData[] = array("id" => $option['id'], "name" => $option['optionname'], "type" => $option['optiontype'], "options" => $options);
            }

            $customfieldsData = [];
            /** @noinspection PhpUndefinedFunctionInspection */
            $customfields = getCustomFields("product", $product['id'], "", "", "on");
            foreach ($customfields as $field) {
                $customfieldsData[] = ["id" => $field['id'], "name" => $field['name'], "description" => $field['description'], "required" => $field['required']];
            }

            $product['customfields']['customfield'] = $customfieldsData;
            $product['configoptions']['configoption'] = $configoptionData;
            $product['isTrial'] = !!$trialInfo[$product['id']]->trial;
            $product['trialNotAllowedReason'] = $trialInfo[$product['id']]->reasonNotAllowed;
        }

        return $products;
    }

    protected function beforeExecute(Request $request)
    {
        $module = Addon::getInstanceById('blazing_servers');

        $token = $module->getConfig('apiToken');

        if (!hash_equals($token, $request->headers->get('Auth-Token', ''))) {
            throw new \Exception('Wrong Auth-Token or no Auth-Token header present');
        }
    }
}
