<?php

/**
 * Hooks of "Trial Products" Module for other plugins integration
 *
 * @author Illia Solonar <illia.solonar[at]gmail.com>
 */

use WHMCS\Database\Capsule;

require_once 'src/TrialsIntegration.php';
require_once 'src/IsolatedConnection.php';

/**
 * @param $userId
 * @param string|null $serverType
 * @return array
 */
function getTrialsUsageInfo($userId, $serverType = null)
{
    $db = new IsolatedConnection();

    $db->setFetchMode(\PDO::FETCH_ASSOC);

    $queryParams = [$userId, $userId];

    $filterServerType = '';
    if ($serverType) {
        $filterServerType = 'INNER JOIN tblproducts p ON p.id = h.packageid AND p.servertype = ?';
        $queryParams[] = $serverType;
    }

    $res = $db->select(
        "SELECT
            h.id AS serviceId,
            h.packageid AS productId,
            h.is_trial,
            h.regdate,
            h.nextduedate,
            h.domainstatus,
            cf_ct.fieldoptions AS category,
            COUNT(ii.id) AS paid_invoices,
            (
              SELECT inv_n.status
              FROM tblinvoiceitems ii
              INNER JOIN tblinvoices inv_n ON inv_n.id = ii.invoiceid
              LEFT JOIN tblupgrades upg ON ii.type = 'Upgrade' AND upg.id = ii.relid
              WHERE ii.userid = ? AND (ii.relid = h.id OR (ii.type = 'Upgrade' AND upg.id IS NOT NULL AND upg.relid = h.id)) AND inv_n.id > inv.id AND inv_n.status != 'Cancelled'
              ORDER BY inv_n.id ASC
              LIMIT 1
            ) AS continue_inv_status
        FROM `tblhosting` h
        INNER JOIN tblinvoiceitems ii ON ii.userid = ? AND ii.type = 'Hosting' AND ii.relid = h.id
        INNER JOIN tblinvoices inv ON inv.id = ii.invoiceid AND inv.status = 'Paid'
        $filterServerType
        LEFT JOIN `tblcustomfields` cf_ct ON cf_ct.relid = h.packageid and cf_ct.fieldname = 'trial_category'
        WHERE (h.is_trial = 1
            OR h.id IN (SELECT serviceid FROM tbltrialproducts_peding_trials))
        GROUP BY h.id",
        $queryParams);

    if (empty($res)) {
        return [];
    }

    $response = [];
    foreach ($res as $row) {
        if (!$row['is_trial']) {
            $status = 'Deferred';
        } else {
            if (empty($row['continue_inv_status'])) {
                $status = 'Not extended';
            } elseif ($row['continue_inv_status'] == 'Paid') {
                $status = 'Extended';
            } elseif ($row['continue_inv_status'] == 'Refunded' || $row['continue_inv_status'] == 'Collections') {
                $status = 'Refunded';
            } else {
                $status = 'Not extended';
            }
        }

        $response[] = [
            'serviceId' => $row['serviceId'],
            'productId' => $row['productId'],
            'nextDueDate' => $row['nextduedate'],
            'category'  => $row['category'],
            'status'    => $status,
            'serviceStatus' => $row['domainstatus']
        ];
    }

    return $response;
}

add_hook('GetTrialProducts', 1, function($vars) {
    return (new TrialsIntegration())->getTrialProducts();
});

add_hook('GetTrialsUsageInfo', 1, function($vars) {
    if (empty($vars['userId'])) {
        return false;
    }

    return getTrialsUsageInfo($vars['userId']);
});

add_hook('GetTrialsUsageSummary', 1, function($vars) {
    if (empty($vars['userId'])) {
        return false;
    }

    $hasPpba = Capsule::table('mod_paypalbilling')->where('id', $vars['userId'])
        ->where('agreement_status', 'active')->exists();

    return [
        'trials' => getTrialsUsageInfo($vars['userId'], isset($vars['serverType']) ? $vars['serverType'] : null),
        'hasPpba' => $hasPpba
    ];
});

add_hook('ProxyBeforeOrderCreated', 1, function($vars) {
    if (isset($vars['customOptions']['trial']) && $vars['customOptions']['trial']) {
        if (TrialsIntegration::getInstance()->isDeferredTrialSetupAvailable($vars['userId'], $vars['productId'])) {
            TrialsIntegration::getInstance()->triggerPendingTrialProcessing();
            return ['noinvoice' => true];
        }
    }
});

add_hook('ProxyOrderCreated', 1, function($vars) {
    TrialsIntegration::getInstance()->onProxyOrderCreated($vars['userId'], $vars['serviceId']);
});

add_hook('ProxyCustomUserServices', 1, function($vars) {
    if(!($res = Capsule::connection()->select('SELECT * FROM tbltrialproducts_peding_trials WHERE userid = ?', [$vars['userId']]))) {
        return;
    }

    $customServices = [];

    foreach($res as $service) {
        $customServices[$service->serviceid] = ['status' => 'pending_trial'];
    }

    return $customServices;
});

add_hook('BlazingServersBeforeOrderCreated', 1, function($vars) {
    if (isset($vars['customOptions']['trial']) && $vars['customOptions']['trial']) {
        if (TrialsIntegration::getInstance()->isDeferredTrialSetupAvailable($vars['userId'], $vars['productId'])) {
            TrialsIntegration::getInstance()->triggerPendingTrialProcessing();
            return ['noinvoice' => true];
        }
    }
});

add_hook('BlazingServersOrderCreated', 1, function($vars) {
    TrialsIntegration::getInstance()->onBlazingServersOrderCreated($vars['userId'], $vars['serviceId']);
});

add_hook('CheckIfTrialPurchaseAllowedForProducts', 1, function($vars) {
        return Util::checkIfTrialPurchaseAllowedForProducts($vars['userId'], $vars['pids']);
});

add_hook('GetTrialServices', 1, function($vars) {
    return Capsule::connection()->select(
        'SELECT h.id, if(pt.id, \'Pending trial\', if(inv.id, \'\', \'Trial period\')) as status FROM tblhosting h
        LEFT JOIN tbltrialproducts_peding_trials pt ON pt.serviceid = h.id
        LEFT JOIN tblinvoiceitems ii ON ii.userid = ? AND ii.type = \'Hosting\' AND ii.relid = h.id AND ii.amount != 0
        LEFT JOIN tblinvoices inv ON inv.id = ii.invoiceid AND inv.status = \'Paid\'
        WHERE  ((h.is_trial = 1 AND h.domainstatus = \'Active\') OR (pt.id AND h.domainstatus = \'Pending\'))
            AND h.userid = ?
        HAVING status != \'\'', [$vars['userId'], $vars['userId']]
    );
});