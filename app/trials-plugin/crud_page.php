<?php
use WHMCS\Database\Capsule;

require_once 'src/Util.php';

$db = Capsule::connection();

$updated = 0;

$trialProducts = getTrialProducts();

if(isset($_POST['new']) && !isset($trialProducts[[$_POST['new']['id']]])) {
    $res = $db->select("SELECT * FROM `tblcustomfields` WHERE relid = ? and fieldname IN ('trial_off', 'free_period', 'trial')", [$_POST['new']['id']]);
    $found = [];
    foreach($res as $cf) {
        $found[$cf->fieldname] = $cf->id;
    }

    if(isset($found['trial_off'])) {
        $db->update(
            "UPDATE `tblcustomfields`
                SET
                    `type` = 'product', `fieldtype`='dropdown', `description`='',`fieldoptions`='0',
                    `regexpr`='[01]',`adminonly`='on',`required`='on',`showorder`='',`showinvoice`='',
                    `sortorder`='0' WHERE `id` = ?",
            [$found['trial_off']]);
    } else {
        $db->insert("INSERT INTO `tblcustomfields`
                (`type`, `relid`, `fieldname`, `fieldtype`, `description`, `fieldoptions`, `regexpr`, `adminonly`, `required`, `showorder`, `showinvoice`, `sortorder`)
            VALUES
                ('product', ?, 'trial_off', 'dropdown', '', '0', '[0-9]+', 'on', 'on', '', '', '0')", [$_POST['new']['id']]);
    }

    if(isset($found['free_period'])) {
        $db->update(
            "UPDATE `tblcustomfields`
                SET
                    `type` = 'product', `fieldtype`='dropdown', `description`='',`fieldoptions`=?,
                    `regexpr`='[0-9]+',`adminonly`='on',`required`='on',`showorder`='',`showinvoice`='',
                    `sortorder`='0' WHERE `id` = ?",
            [$_POST['new']['free_period'], $found['free_period']]);
    } else {
        $db->insert("INSERT INTO `tblcustomfields`
                (`type`, `relid`, `fieldname`, `fieldtype`, `description`, `fieldoptions`, `regexpr`, `adminonly`, `required`, `showorder`, `showinvoice`, `sortorder`)
            VALUES
                ('product', ?, 'free_period', 'dropdown', '', ?, '[0-9]+', 'on', 'on', '', '', '0')", [$_POST['new']['id'], $_POST['new']['free_period']]);
    }

    if(isset($found['trial'])) {
        $db->update(
            "UPDATE `tblcustomfields`
                SET
                    `type` = 'product', `fieldtype`='dropdown', `description`='',`fieldoptions`='',
                    `regexpr`='[0-9]+',`adminonly`='on',`required`='on',`showorder`='',`showinvoice`='',
                    `sortorder`='0' WHERE `id` = ?",
            [$found['trial']]);
    } else {
        $db->insert("INSERT INTO `tblcustomfields`
                (`type`, `relid`, `fieldname`, `fieldtype`, `description`, `fieldoptions`, `regexpr`, `adminonly`, `required`, `showorder`, `showinvoice`, `sortorder`)
            VALUES
                ('product', ?, 'trial', 'dropdown', '', '', '[0-9]+', 'on', 'on', '', '', '0')", [$_POST['new']['id']]);
    }

    if(isset($found['category'])) {
        $db->update(
            "UPDATE `tblcustomfields`
                SET
                    `type` = 'product', `fieldtype`='dropdown', `description`='',`fieldoptions`=?,
                    `regexpr`='[0-9]+',`adminonly`='on',`required`='on',`showorder`='',`showinvoice`='',
                    `sortorder`='0' WHERE `id` = ?",
            [$_POST['new']['category'], $found['category']]);
    } else {
        $db->insert("INSERT INTO `tblcustomfields`
                (`type`, `relid`, `fieldname`, `fieldtype`, `description`, `fieldoptions`, `regexpr`, `adminonly`, `required`, `showorder`, `showinvoice`, `sortorder`)
            VALUES
                ('product', ?, 'trial_category', 'dropdown', '', ?, '[0-9]+', 'on', 'on', '', '', '0')", [$_POST['new']['id'], $_POST['new']['category']]);
    }

    $trialProducts = getTrialProducts();
}

$products = $db->select('
        SELECT p.id, p.name, g.name as group_name
        FROM `tblproducts` p
        INNER JOIN `tblproductgroups` g ON g.id = p.gid
        LEFT JOIN `tblcustomfields` ON tblcustomfields.relid = p.id and tblcustomfields.fieldname = \'trial\'
        LEFT JOIN `tblcustomfields` cf2 ON cf2.relid = p.id and cf2.fieldname = \'trial_off\'
        WHERE p.retired != 1 and (tblcustomfields.id IS NULL OR cf2.fieldoptions = \'1\')
        ORDER BY g.order, p.order');

if(isset($_POST['products'])) {
    foreach($_POST['products'] as $id => $postProduct) {
        if(!isset($trialProducts[$id]))
            continue;

        if($postProduct['free_period'] != -1) {
            if(!ctype_digit($postProduct['free_period']))
                continue;

            $isUpdated = 0;
            if($postProduct['free_period'] != $trialProducts[$id]->free_period) {
                if($postProduct['free_period'] == '')
                    continue;

                if($db->update('UPDATE `tblcustomfields` SET `fieldoptions` = ? WHERE relid = ? and fieldname = \'free_period\'', [$postProduct['free_period'], $id])) {
                    $trialProducts[$id]->free_period = $postProduct['free_period'];

                    $isUpdated = 1;
                }
            }

            if ($postProduct['category'] != $trialProducts[$id]->category) {
                if ($trialProducts[$id]->category_field_id) {
                    if($db->update('UPDATE `tblcustomfields` SET `fieldoptions` = ? WHERE relid = ? and fieldname = \'trial_category\'', [$postProduct['category'], $id])) {
                        $trialProducts[$id]->category = $postProduct['category'];

                        $isUpdated = 1;
                    }
                } else {
                    if ($db->insert("INSERT INTO `tblcustomfields`
                            (`type`, `relid`, `fieldname`, `fieldtype`, `description`, `fieldoptions`, `regexpr`, `adminonly`, `required`, `showorder`, `showinvoice`, `sortorder`)
                        VALUES
                            ('product', ?, 'trial_category', 'dropdown', '', ?, '[0-9]+', 'on', 'on', '', '', '0')", [$id, $postProduct['category']])
                    ) {
                        $trialProducts[$id]->category = $postProduct['category'];

                        $isUpdated = 1;
                    }
                }
            }

            $updated += $isUpdated;
        } else {
            if($db->update(
                "UPDATE `tblcustomfields`
                    SET
                        `type` = 'product', `fieldtype`='dropdown', `description`='',`fieldoptions`='1',
                        `regexpr`='[10]',`adminonly`='on',`required`='on',`showorder`='',`showinvoice`='',
                        `sortorder`='0' WHERE `relid` = ? and fieldname = 'trial_off'",
                [$id])
            ) {
                unset($trialProducts[$id]);
            }
        }
    }
}

$productsGrouped = [];
foreach ($products as $element) {
    $productsGrouped[$element->group_name][$element->id] = $element;
}

return Util::renderTemplate(__DIR__ . '/templates/admin.tpl', [
    'page' => 'crud',
    'trialProducts' => $trialProducts,
    'productsGrouped' => $productsGrouped,
    'updated' => $updated,
    'baseUrl' => Util::getBaseUrl()
]);