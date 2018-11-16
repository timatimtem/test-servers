<?php

use WHMCS\Module\Blazing\Servers\Vendor\WHMCS\Module\Framework\Addon;

require_once __DIR__ . '/bootstrapper.php';

return Addon::registerModuleByFile(__FILE__, [
    'name'        => 'Blazing Servers',
    'description' => 'Servers dashboard integration addon',
    'version'     => '0.1',
    'author'      => 'Illia S',
    'fields'      => [
        'apiToken' => [
            'FriendlyName' => 'Authorization token to secure API calls',
            'Type' => 'text',
            'Size' => 60,
            'Default' => ''
        ],
        'serversDashboardUrl' => [
            'FriendlyName' => 'Will be used for redirects from WHMCS',
            'Type' => 'text',
            'Size' => 75,
            'Description' => 'Example: https://dashboard.dev.sprious.com',
            'Default' => ''
        ],
    ],
    'config'      => [
        'logPath' => __DIR__ . '/logs/user-{user}.log',
    ]
])->registerModuleListeners([
]);
