<?php

use WHMCS\Module\Blazing\Servers\Vendor\Symfony\Component\HttpFoundation\JsonResponse;
use WHMCS\Module\Blazing\Servers\Vendor\Symfony\Component\HttpFoundation\Request;
use WHMCS\Module\Blazing\Servers\Vendor\Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use WHMCS\Module\Blazing\Servers\Controller\APIController;
use WHMCS\Module\Blazing\Servers\Controller\RequestArgumentsValueResolver;
use WHMCS\Module\Blazing\Servers\Exception\UserFriendlyException;
use WHMCS\Module\Blazing\Servers\Logger;

require_once __DIR__ . '/bootstrapper.php';

// Catch request
$request = Request::createFromGlobals();

// Handle request
$controller = new APIController();
$return = $controller->handleRequestAction($request);
$response = new JsonResponse($return);

// Send response
$response->send();