<?php

use WHMCS\Module\Blazing\Servers\Vendor\WHMCS\Module\Framework\Helper;
use Illuminate\Database\Query\Grammars\MySqlGrammar;

$bootstrapper = require __DIR__ . '/vendor/and/whmcs-module-framework/bootstrapper.php';
$bootstrapper();

define('ROOT_DIR', __DIR__);

Helper::conn()->setQueryGrammar(new MySqlGrammar());