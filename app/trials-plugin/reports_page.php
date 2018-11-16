<?php

use WHMCS\Database\Capsule;

require_once 'src/Util.php';

function getTrialsUsageInfo($count = false, $email = '', $page = 0, $limit = 0) {
    $whereEmail = '';
    $params = [];

    if ($email != '') {
        $whereEmail =
          "AND h.id IN (
             SELECT h.id FROM tblhosting h
             WHERE userid IN (SELECT id FROM tblclients WHERE email LIKE ?)
          )";
        $params[] = '%' . $email . '%';
    }

    if ($count) {
        $query =
            "SELECT COUNT(*) AS count_rows
            FROM `tblhosting` h
            INNER JOIN tblclients c ON c.id = h.userid
            INNER JOIN tblproducts p ON p.id = h.packageid
            INNER JOIN tbltrialproductsemailpayers pm ON pm.id = h.payeremailid
            WHERE (h.is_trial = 1
                OR h.id IN (SELECT serviceid FROM tbltrialproducts_peding_trials))
                $whereEmail";
    } else {
        if ($page) {
            $limitPart = "LIMIT $limit OFFSET " . $limit * ($page - 1);
        } else {
            $limitPart = '';
        }

        $query =
            "SELECT
                h.*, 
                c.email as client_email,
                pm.payeremail as payer_email,
                if(tp.id IS NOT NULL, 1, 0) AS is_pending_trial,
                ppb.paypalbillingid AS active_ppba_id,
                emails.payeremail AS active_ppba_email,
                p.id AS product_id,
                p.name AS product_name
            FROM (
                SELECT
                        h.*,
                        SUM(if(inv.status = 'Paid' AND (ii.type = 'Hosting' or upg.id IS NOT NULL), ii.amount, 0)) as invoices_amount
                    FROM (
                        SELECT
                        *
                        FROM `tblhosting` h
                        WHERE (h.is_trial = 1
                            OR h.id IN (SELECT serviceid FROM tbltrialproducts_peding_trials))
                            $whereEmail
                        ORDER BY h.id DESC
                        $limitPart
                    ) h
            
                    
                    LEFT JOIN tblinvoiceitems ii ON (ii.userid = h.userid AND ((ii.type = 'Hosting' AND ii.relid = h.id) or ii.type = 'Upgrade'))
                    LEFT JOIN tblupgrades upg ON ii.type = 'Upgrade' AND upg.id = ii.relid AND upg.relid = h.id
                    LEFT JOIN tblinvoices inv ON inv.id = ii.invoiceid
            
                    GROUP BY h.id
            ) h  
            INNER JOIN tblclients c ON c.id = h.userid
            INNER JOIN tblproducts p ON p.id = h.packageid
            INNER JOIN tbltrialproductsemailpayers pm ON pm.id = h.payeremailid
            LEFT JOIN tbltrialproducts_peding_trials tp ON tp.serviceid = h.id
            LEFT JOIN mod_paypalbilling ppb ON ppb.id = h.userid AND ppb.agreement_status = 'Active'
            LEFT JOIN tbltrialproductsppbaemail ppbemails ON ppbemails.paypalbillingid = ppb.paypalbillingid
            LEFT JOIN tbltrialproductsemailpayers emails ON  emails.id = ppbemails.emailid";
    }

    return Capsule::connection()->select($query, $params);
}


function generatePaginationList($pages, $page) {
    $show = 10;

    $offset = ($page + ceil($show / 2)) - $pages;
    $start = $page - (round($show / 2) - 1) - ($offset > 0 ? $offset : 0);
    $start = $start > 0 ? $start : 1;

    $list = [];
    for($i = 0; $i < $show; $i++) {
        $nextPage = $i + $start;

        if($nextPage > $pages)
            break;

        $list[] = $i + $start;
    }
    return $list;
}

if (isset($_REQUEST['email'])) {
    $email = $_REQUEST['email'];
} else {
    $email = '';
}

// pagination
$limit = 40;
$count = getTrialsUsageInfo(true, $email)[0]->count_rows;
$pages = ceil($count / $limit);
$page = $_GET['report_page'] ? (int) $_GET['report_page'] : 1;
$paginationList = generatePaginationList($pages, $page);

$baseUrl = Util::getBaseUrl();
if (isset($_POST['export-csv'])) {
    $trialsUsageInfo = getTrialsUsageInfo(false, $email);
} else {
    $trialsUsageInfo = getTrialsUsageInfo(false, $email, $page, $limit);
}
$reportData = [];
$secsInDay = 60 * 60 * 24;
foreach ($trialsUsageInfo as $row) {
    $extendedOrNot = '';
    if (!$row->is_trial && $row->is_pending_trial) {
        $status = 'Waiting PPBA';
    } else {
        $regDate = new \DateTime($row->regdate);
        $dueDate = new \DateTime($row->nextduedate);
        $diff = ($dueDate->getTimestamp() - $regDate->getTimestamp()) / $secsInDay;
        if ($diff < MAX_TRIAL_PERIOD) {
            if ($row->domainstatus == 'Active') {
                $status = 'Active';
            } else {
                $status = 'Ended';
                $extendedOrNot = 'NO';
            }
        } else {
            $status = 'Ended';
            $extendedOrNot = 'YES';
        }
    }

    $reportData[] = [
        'ID' => $row->id,
        'User ID' => $row->userid,
        'Client Email' => $row->client_email,
        'Product' => $row->product_name,
        'Registration date' => $row->regdate,
        'Due date' => $row->nextduedate,
        'Purchase PP email' => $row->payer_email,
        'Trial status' => $status,
        'Extended' => $extendedOrNot,
        'Active PPBA id' => ($row->active_ppba_id) ? $row->active_ppba_id : 'Not active',
        'Active PPBA email' => ($row->active_ppba_email) ? $row->active_ppba_email : 'N/A',
        'Paid invoices total amount' => $row->invoices_amount != null ? $row->invoices_amount : 'None'
    ];
}

if (isset($_POST['export-csv'])) {
    require_once 'src/CsvExporter.php';
    CsvExporter::exportReport('trials_report', $reportData);
} else {
    foreach($reportData as &$row) {
        $row['Client Email'] = '<a href="' . $baseUrl . 'admin/clientssummary.php?userid=' . $row['User ID'] . '">' . $row['Client Email'] . '</a>';
        unset($row['User ID']);

        $row['Product'] = '<a href="' . $baseUrl . 'admin/clientsservices.php?productselect=' . $row['ID'] . '">' . $row['Product'] . '</a>';

        foreach($row as $key => $value) {
            if (in_array(strtolower($value), ['ended', 'no', 'not active', 'n/a', 'none'])) {
               $row[$key] = '<span style="color: red">' . $value . '</span>';
            } elseif (in_array(strtolower($value), ['waiting ppba', 'yes'])) {
                $row[$key] = '<span style="color: green">' . $value . '</span>';
            }
        }
    }
}

return Util::renderTemplate(__DIR__ . '/templates/admin.tpl', [
    'page' => 'reports',
    'email' => $email,
    'currentPage' => $page,
    'count' => $count,
    'pages' => $pages,
    'paginationList' => $paginationList,
    'reportData' => $reportData,
    'baseUrl' => $baseUrl
]);
