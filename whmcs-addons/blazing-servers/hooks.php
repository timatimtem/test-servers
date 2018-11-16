<?php

use WHMCS\Module\Blazing\Servers\Events;
use WHMCS\Module\Blazing\Servers\Vendor\WHMCS\Module\Framework\ModuleHooks;

require_once __DIR__ . '/bootstrapper.php';

ModuleHooks::registerHooks(__FILE__, [
    Events\TrialPricingOverrode::class
]);
