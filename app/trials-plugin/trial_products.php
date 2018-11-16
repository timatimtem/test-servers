<?php

/**
 * "Trial Products" Module for WHMCS
 *
 * This addon allows you to sell trial products with a custom time trial time.
 * If the user wants to re-order the trial product from another account, he will be added to the banlist, and his order will be canceled and the funds returned.
 *
 * @author Ruslan Ivanov
 */

use WHMCS\Database\Capsule;

require_once 'src/Util.php';

define('MAX_TRIAL_PERIOD', 10);

/**
 * @return array
 */
function trial_products_config()
{
    $configarray = [
        "name"        => "Trial Products",
        "description" => "This addon allows you to sell trial products with a custom time trial time<br>"
            . "Trial price will be set to $0",
        "version"     => "1.1 <sup style='color: #46a546'>stable</sup>",
        "author"      => "Ruslan Ivanov",
        "fields"      => [
            'removePromo' => [
                "FriendlyName" => "Remove promotion",
                "Type"         => "yesno",
                "Description"  => "If checked, promotion will be removed on trial setup",
            ]
            /*"messagename" => [
                "FriendlyName" => "Email template",
                "Type"         => "text",
                "Description"  => "The name of the client email template to send",
            ],
            "sandbox" => [
                "FriendlyName" => "Enable sandbox mode?",
                "Type"         => "yesno",
                "Description"  => "If now you using sandbox PayPal mode in you WHMCS please tick it",
            ],
            "trialprice" => [
                "FriendlyName" => "Trial product price",
                "Type"         => "text",
                "Description"  => "(if 0 product will be purchased automatically)",
                "Default" => "0.0"
            ],*/
        ],
    ];

    return $configarray;
}

/**
 * Add is_trial column into tblhosting
 */
function trial_products_activate() {

    $query = "ALTER TABLE `tblhosting` ADD `is_trial` TINYINT(1) NULL DEFAULT 0 AFTER `updated_at`;";
    $result = full_query($query);

    $query = "CREATE TABLE IF NOT EXISTS `tbltrialproductsemailpayers` ( `id` INT NOT NULL AUTO_INCREMENT , `payeremail` VARCHAR(255) NOT NULL , `created_at` TIMESTAMP NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
    $result = full_query($query);

    $query = "ALTER TABLE `tblhosting` ADD `payeremailid` INT NULL DEFAULT NULL AFTER `updated_at`";
    $result = full_query($query);

    full_query("CREATE TABLE IF NOT EXISTS `tbltrialproductsppbaemail` ( `id` INT NOT NULL AUTO_INCREMENT,`emailid` INT NOT NULL,`paypalbillingid` text NOT NULL, PRIMARY KEY (`id`) ) ENGINE=InnoDB");

    full_query(
        "CREATE TABLE IF NOT EXISTS `tbltrialproducts_peding_trials` (
            `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `serviceid` int(10) UNSIGNED NOT NULL,
            `userid` int(10) UNSIGNED NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB");

    $oldTrials = Capsule::connection()->select(
        'SELECT
            cf.relid
        FROM tblcustomfields cf
        LEFT JOIN tblcustomfields cf2 ON cf2.relid = cf.relid
            AND cf2.fieldname = \'trial_off\'
        WHERE cf.fieldname = \'trial\' AND cf2.id IS NULL'
    );

    if (!$oldTrials) {
        return;
    }

    foreach ($oldTrials as $trial) {
        Capsule::connection()->insert("INSERT INTO `tblcustomfields`
                (`type`, `relid`, `fieldname`, `fieldtype`, `description`,
                `fieldoptions`, `regexpr`, `adminonly`, `required`, `showorder`,
                `showinvoice`, `sortorder`)
            VALUES
                ('product', ?, 'trial_off', 'dropdown', '', '0', '[0-9]+', 'on', 'on', '', '', '0')",
            [$trial->relid]
        );
    }
}

/**
 * Drop is_trial column into tblhosting
 */
function trial_products_deactivate() {

    /*$query = "ALTER TABLE `tblhosting` DROP `is_trial`";
    $result = full_query($query);

    $query = "ALTER TABLE `tblhosting` DROP `payeremailid`";
    $result = full_query($query);

    $query = "DROP TABLE tbltrialproductsemailpayers";
    $result = full_query($query);*/

}

function getTrialProducts() {
    $trialProducts = Capsule::connection()->select(
        'SELECT
          p.id, p.name,
          cf2.fieldoptions as free_period,
          cf_ct.fieldoptions as category,
          cf_ct.id as category_field_id
        FROM `tblcustomfields` cf
        LEFT JOIN `tblproducts` p ON p.id = cf.relid
        LEFT JOIN `tblcustomfields` cf2 ON cf2.relid = cf.relid and cf2.fieldname = \'free_period\'
        LEFT JOIN `tblcustomfields` cf3 ON cf3.relid = cf.relid and cf3.fieldname = \'trial_off\'
        LEFT JOIN `tblcustomfields` cf_ct ON cf_ct.relid = cf.relid and cf_ct.fieldname = \'trial_category\'
        WHERE cf.fieldname = \'trial\' and cf3.fieldoptions = \'0\' and p.retired != 1'
    );

    $mapped = [];
    foreach($trialProducts as $p) {
        $mapped[$p->id] =  $p;
    }
    return $mapped;
}

function trial_products_output($vars) {
    if (!isset($_GET['page']) || $_GET['page'] == 'crud') {
        echo include 'crud_page.php';
    } else {
        echo include 'reports_page.php';
    }
}