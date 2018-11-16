<?php

/**
 * Hook for WHMCS of "Trial Products" Module
 *
 * @author Ruslan Ivanov
 * @author And <and.webdev[at]gmail.com>
 * @author Illia Solonar <illia.solonar[at]gmail.com>
 */

use WHMCS\Database\Capsule;

require_once 'src/Util.php';
require_once 'src/TrialsIntegration.php';

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

require_once 'hooks_external.php';

add_hook('ClientAreaFooterOutput', 1, function($vars) {
    Capsule::connection()->setFetchMode(PDO::FETCH_OBJ);

    // get client id
    $clientid = $_SESSION['uid'];

    if(!empty($vars['products'])) {
        $products = &$vars['products'];
    } else if(!empty($vars['productinfo'])) {
        $products = [&$vars['productinfo']];
    } else
        return;

    $adjustments = [];
    $checkedProducts = [];
    foreach($products as $index => &$product) {
        if(array_search($product['pid'], $checkedProducts) !== false)
            continue;

        $checkedProducts[] = $product['pid'];

        // check if this product is trial
        $options = Capsule::table('tblcustomfields')->where('relid', $product['pid'])
            ->where('fieldname', 'trial_off')
            ->where('fieldoptions', '0')
            ->first();

        if(!empty($options)) {

            // get prices for this product
            $price = Capsule::table('tblpricing')->where('relid', $product['pid'])->where('type', 'product')->first();

            $hostings = Capsule::table('tblhosting')->where('userid', $clientid)->where('packageid', $product['pid'])->get();

            foreach ($hostings as $hosting) {

                $amount = trialProductsCalcNextAmount($hosting->billingcycle, $price);

                if($amount != $hosting->amount) {

                    continue 2;

                }

            }

            // check exist trial product id of the this client
            $existTrialProduct = Capsule::table('tblhosting')->where('userid', $clientid)->where('packageid', $product['pid'])->where('is_trial', 1)->first();

            if(is_null($existTrialProduct)) {
                $freePeriod = trialProductsGetFreePeriod($product['pid']);

                $adjustments[$index] = [
                    'pid' => $product['pid'],
                    'freePeriod' => $freePeriod,
                ];

                if(($defaultPrice = Util::getDefaultPrice($product['pid'])) !== false) {
                    $adjustments[$index]['pricing'] = '$' . number_format(Util::getTrialProductPrice(), 2, '.', '') . ' / ' . number_format($defaultPrice, 2, '.', '') . ' USD';
                } else if (!isset($_GET['a'])) {
                    $adjustments[$index]['pricing'] = '$' . number_format(Util::getTrialProductPrice(), 2, '.', '') . ' / ' . $product['pricing']['minprice']['price'];
                }
            }

        }

    }

    if($vars['filename'] == 'cart') {
        if($_GET['a'] == 'view') {
            $reasons = json_encode(Util::getTrialsNotAllowedReasons());
            $supportEmail = Capsule::table('tblconfiguration')->where('setting', 'Email')->value('value');

            if (isset($_SESSION['uid'])) {
                $modal = '#getTrialModal';
            } else {
                $modal = '#getTrialModalForUnathorized';
            }

            $a = json_encode($adjustments, JSON_FORCE_OBJECT);
            $script =
                "<script>
                    var adjustments = $a;
                    var reasons = $reasons;
                    var ppbaNotSet = false;

                    var len = $('.view-cart-items .item').length;
                    for(var i = 0; i < len; i++) {
                        if(i in adjustments) {
                            var item = $('.view-cart-items .item').eq(i);
                            var elem = item.find('.item-title a');

                            elem.before(' <sup style=\"color: red\">(trial)</sup>');
                            if(reasons[adjustments[i].pid] == " . Util::PPBA_NOT_SET . ") {
                                ppbaNotSet = true;
                                // elem.before(' <a href=\"#\" role=\"button\" data-toggle=\"modal\" data-target=\"#getTrialModal\" class=\"btn btn-link btn-xs\"><i class=\"fa fa-hourglass-start\"></i> Get trial</a>');
                            } else if (reasons[adjustments[i].pid] == " . Util::EXIST_TRIAL_ON_SAME_PPBA_EMAIL . ") {
                                item.find('.item-group')
                                    .after(
                                        '<p style=\"padding: 5px\" class=\" text-justify text-danger\">You have already received a free trial of this product with your PayPal account. \
                                        You are not eligible to receive another free trial of this product. \
                                        For assistance with this issue, please contact our support team at <a href=\"$supportEmail\">$supportEmail</a></p>');
                            } else {
                                item.find('.item-group')
                                    .after('This is a free trial. You will be automatically billed after '
                                        + adjustments[i].freePeriod + ' days if you do not cancel your PayPal Billing Agreement.');
                            }


                            if('pricing' in adjustments[i]) {
                                item.find('.item-price span:eq(0)').html(adjustments[i].pricing);
                            }
                        }
                    }

                    $('#checkout').on('click', function(e) {
                        if (ppbaNotSet) {
                            $('$modal').modal('show');
                            e.preventDefault();
                        }
                    });";

            if(isset($_GET['ppba'])) {
                $s = 'var products = {};
                    var i = 0;
                    $(\'.view-cart-items .item\').each(function() {
                        if(!(i in adjustments)) {
                            i++; return;
                        }

                        i++;

                        if($(this).val() in products)
                            return;

                        products[$(this).val()] = 1;

                        $(this).find(\'.item-price span:first-child\')
                            .html(\'<p style="font-size: 12px;">The pricing in your cart will update in a few seconds to reflect the free trial....</p>\');
                    });

                    setTimeout(
                        function() { location.href=location.href.replace(/&?(ppba)=([^&]$|[^&]*)/gi, ""); },
                        8000
                    )';

                $script .= $s;
            }

            $script .= '</script>';

            $modal = Util::renderTemplate(__DIR__ . '/templates/modal.tpl', [
                'baseUrl' => Util::getBaseUrl(),
            ]);

            return $script . $modal;
        } else if($_GET['a'] == 'confproduct' && !empty($adjustments)) {
            $script =
                "<script>
                    $('.product-info .product-title')[0].innerHTML += ' <sup style=\"color: red\">(trial)</sup>';

                    var handlerSet = false;
                    var handled = false;
                    var response = '';
                    $(document).ajaxComplete(function(event, xhr, settings) {
                        console.log(1);
                        if(!handlerSet && settings.url == 'cart.php') {
                            xhr.done(function(data) {
                                if(!handled) {
                                    response = data;
                                    handled = true;

                                    $('#frmConfigureProduct').append('<input type=\"hidden\" name=\"skipOverride\" value=\"1\">');

                                    recalctotals();
                                } else {
                                    var elem = $(response);

                                    $('#producttotal > .clearfix .pull-right').html(elem.find('.clearfix .pull-right:eq(0)').html());
                                    $('#producttotal .total-due-today .amt').html(elem.find('.amt').html());
                                    $('#frmConfigureProduct input[name=\"skipOverride\"]').remove();

                                    handled = false;
                                }
                            });
                        }
                    });
                </script>";

            return $script;
        } else if(!isset($_GET['a'])) {
            $a = json_encode($adjustments, JSON_FORCE_OBJECT);
            $script =
                "<script>
                    var adjustments = $a;

                    var len = $('.products .product').length;
                    for(var i = 0; i < len; i++) {
                        if(i in adjustments) {
                            var item = $('.products .product').eq(i);
                            item.find('header span')[0].innerHTML += ' <sup style=\"color: red\">(trial)</sup>';

                            if('pricing' in adjustments[i]) {
                                item.find('.price').html(adjustments[i].pricing);
                            }
                        }
                    }
                </script>";

            return $script;
        }
    }
});

add_hook('ClientAreaPage', 1, function($vars) use (&$genInvoiceFor) {
    // AcceptOrder hook is not executed if product
    // is purchased in whmcs client area with $0 cost
    if($genInvoiceFor) {
        localAPI('genInvoices', ['serviceids' => [$genInvoiceFor]], trial_products_get_admin_username());
    }

    // whatever they do, if they are logged in
    // and redirectToCartAfterLogin is set redirect to cart
    if (isset($_GET['redirectToCartAfterLogin']) && !isset($_SESSION['uid'])) {
        $_SESSION['mod_trial_r'] = 'cart_after_signin';
    } else if ($_SESSION['mod_trial_r'] == 'cart_after_signin' && isset($_SESSION['uid'])) {
        header('Location: ' . Util::getBaseUrl() . 'cart.php?a=view');
        unset($_SESSION['mod_trial_r']);
        exit();
    }

    // redirect back to cart or dashboard after ppba is set
    if($vars['filename'] == 'paypalbilling') {
        if(isset($_SESSION['mod_trial_r'])) {
            switch ($_SESSION['mod_trial_r']) {
                case 'cart':
                    $ppbar = Capsule::table('mod_paypalbilling')->where('id', $_SESSION['uid'])->where('agreement_status', 'active')->first();

                    unset($_SESSION['mod_trial_r']);

                    if(isset($_GET['token']) || Capsule::table('mod_paypalbilling')->where('id', $_SESSION['uid'])->where('agreement_status', 'active')->first()) {
                        header('Location: ' . Util::getBaseUrl() . 'cart.php?a=view&ppba=true');
                    }
                    break;
                case 'dashboard':
                    unset($_SESSION['mod_trial_r']);

                    if ($url = Capsule::table('tbladdonmodules')
                        ->where('module', 'blazing_proxy_seller')
                        ->where('setting', 'proxyDashboardUrl')
                        ->value('value')
                    ) {
                        header('Location: ' . rtrim($url, '/') . '/dashboard');
                    }
                    break;
                case 'serversDashboard':
                    unset($_SESSION['mod_trial_r']);

                    if ($url = Capsule::table('tbladdonmodules')
                        ->where('module', 'blazing_servers')
                        ->where('setting', 'serversDashboardUrl')
                        ->value('value')
                    ) {
                        header('Location: ' . rtrim($url, '/') . '/dashboard');
                    }
                    break;
            }
        } else {
            if (isset($_GET['redirectToCart'])) {
                $_SESSION['mod_trial_r'] = 'cart';
            } else if ($_GET['redirectToDashboard']) {
                $_SESSION['mod_trial_r'] = 'dashboard';
            } else if ($_GET['redirectToServersDashboard']) {
                $_SESSION['mod_trial_r'] = 'serversDashboard';
            } else {
                unset($_SESSION['mod_trial_r']);
            }
        }
    }
});

add_hook('OrderProductPricingOverride', 0, function ($vars) {
    if (isset($_SESSION['adminid'])) {
        return;
    }

    if(!empty(run_hook('TrialPricingOverride', [
        'userid' => $_SESSION['uid'],
        'pid' => $vars['pid']
    ]))) {
        return false;
    }

    // show real price on 'configurate product' page
    if((isset($_POST['ajax']) && $_POST['ajax'] && isset($_POST['a']) && $_POST['a'] == 'confproduct' && isset($_POST['skipOverride'])))
        return;

    $overridePriceIfPPBANotSet = $_REQUEST['a'] == 'confproduct' || $_REQUEST['a'] == 'view';

    try {

        Capsule::connection()->setFetchMode(PDO::FETCH_OBJ);

        // if this the new forming cycle of the cart
        if($vars['key'] == 0) {

            // clearing trial products array and set products num is 0
            unset($_SESSION['trial']);

        }

        if($vars['proddata']['qty'] > 0) {

            // get client id
            $clientid = $_SESSION['uid'];

            // check if this product is trial
            $options = Capsule::table('tblcustomfields')->where('relid', $vars['pid'])
                ->where('fieldname', 'trial_off')
                ->where('fieldoptions', '0')
                ->first();

            if(!empty($options)) {

                // get prices for this product
                $price = Capsule::table('tblpricing')->where('relid', $vars['pid'])->where('type', 'product')->first();
                if(Util::trialPurchaseAllowed($clientid, $vars['pid']) || ($overridePriceIfPPBANotSet && Util::getTrialsNotAllowedReasons()[$vars['pid']] === Util::PPBA_NOT_SET)) {
                    $return = [];

                    // if this product not exist in session array of the trial products
                    if(!isset($_SESSION['trial'][$vars['pid']])) {
                        $billingcycle = $vars['proddata']['billingcycle'];

                        Util::setDefaultPrice($vars['pid'], (float) $price->$billingcycle);

                        $trialPrice = Util::getTrialProductPrice();

                        // if price is 0, it will not be recognized by whmcs when rendering cart page
                        // 0.001 will be rounded to 0.00
                        if(!$trialPrice)
                            $trialPrice = 0.001;

                        // return prices
                        $return = [
                            'recurring' => $trialPrice,
                            'setup' => '0.00'
                        ];

                        if($vars['proddata']['qty'] > 1) {
                            $return['recurring'] = ( (float)$return['recurring'] + (float)$price->$billingcycle * ( (int)$vars['proddata']['qty'] - 1) )
                                / (int)$vars['proddata']['qty'];

                        }

                        // add id of the this trial product to trial products array in the session.
                        $_SESSION['trial'][$vars['pid']] = true;

                        TrialsIntegration::getInstance()->preventDeferredTrialSetup();

                        run_hook('TrialPricingOverrode', [
                            'userid' => $_SESSION['uid'],
                            'pid' => $vars['pid'],
                            'trial' => true
                        ]);

                        return $return;

                    }

                } else {
                    run_hook('TrialPricingOverrode', [
                        'userid' => $_SESSION['uid'],
                        'pid' => $vars['pid'],
                        'trial' => false,
                        'pendingTrial' => TrialsIntegration::getInstance()->isPendingTrial(),
                        'reason' => Util::getTrialNotAllowedReason($vars['pid'])
                    ]);
                }

            }

        }

    } catch (Exception $e) {

        logActivity('Error in "Trial Products" module! Please contact with developer. Error message - "'. $e->getMessage() .'"');
        return true;

    }

});

add_hook('InvoiceCreated', 3, function($vars) {

    Capsule::connection()->setFetchMode(PDO::FETCH_OBJ);

    $invoiceitems = Capsule::table('tblinvoiceitems')->where('invoiceid', $vars['invoiceid'])
        ->where('type', 'Hosting')->get();

    foreach ($invoiceitems as $item) {

        try {

            $hosting = Capsule::table('tblhosting')->where('id', $item->relid)->first();

            // check if trial is disabled
            $trialOff = Capsule::table('tblcustomfields')->where('relid', $hosting->packageid)
                ->where('fieldname', 'trial_off')
                ->where('fieldoptions', '0')
                ->first();
            if(is_null($trialOff))
                return;

            $freePeriod = Capsule::table('tblcustomfields')->where('relid', $hosting->packageid)
                ->where('fieldname', 'free_period')
                ->first();

            $options = Capsule::table('tblcustomfields')->where('relid', $hosting->packageid)->where('fieldname', 'trial')->first();

            // check if this product is trial
            if(!is_null($options) && !is_null($freePeriod) && $hosting->firstpaymentamount == Util::getTrialProductPrice()) {
                $traitServiceId = null;
                if ($result = run_hook('FindTraitProductId', ['id' => $hosting->id])) {
                    $traitServiceId = $result[0]['id'];
                }

                Capsule::connection()->setFetchMode(PDO::FETCH_OBJ);
                $exist = Capsule::table('tblhosting')->where('is_trial', 1)
                    ->where('userid', $item->userid)
                    ->where('packageid', $traitServiceId ? $traitServiceId : $hosting->packageid)
                    ->first();

                // check exist this trial product from the user
                if (is_null($exist)) {

                    // get price for all billing cycles
                    $price = Capsule::table('tblpricing')->where('relid', $hosting->packageid)->where('type', 'product')->first();

                    // calculate amount for continue product
                    $amount = trialProductsCalcNextAmount($hosting->billingcycle, $price);

                    // save price to trial custom field value
                    $isFieldExists = Capsule::table('tblcustomfieldsvalues')
                        ->where('fieldid', $options->id)->where('relid', $hosting->id)->first();
                    if (is_null($isFieldExists)) {
                        Capsule::table('tblcustomfieldsvalues')->insert([
                            'fieldid' => $options->id,
                            'relid' => $hosting->id,
                            'value' => $amount
                        ]);

                        Capsule::table('tblcustomfieldsvalues')->insert([
                            'fieldid' => $freePeriod->id,
                            'relid' => $hosting->id,
                            'value' => $freePeriod->fieldoptions
                        ]);
                    }
                    else {
                        Capsule::table('tblcustomfieldsvalues')
                            ->where('fieldid', $options->id)
                            ->where('relid', $hosting->id)
                            ->update(['value' => $amount]);
                    }

                    // get free period value
                    $days = trialProductsGetFreePeriod($hosting->packageid);

                    // create next due date
                    $replace_date = new DateTime(getInvoicePayUntilDate($hosting->nextduedate, $hosting->billingcycle));
                    $replace_date = fromMySQLDate($replace_date->format('Y-m-d'));

                    $new_date = new DateTime();
                    $new_date->modify('+' . $days . ' days');
                    $new_date = fromMySQLDate($new_date->format('Y-m-d'));

                    $description = str_replace($replace_date, $new_date, $item->description);

                    Capsule::table('tblinvoiceitems')->where('id', $item->id)->update(['description' => $description]);

                }

            }

        } catch (Exception $e) {
            logActivity('TRIAL MODULE ERROR -> ' . $e->getTraceAsString());
        }

    }

});

add_hook('InvoiceCreationPreEmail', 100, function($vars) {
    $serviceId = Capsule::table('tblinvoiceitems')->where('invoiceid', $vars['invoiceid'])->value('relid');

    if (Capsule::table('tbltrialproducts_peding_trials')->where('serviceid', $serviceId)->exists()) {
        Capsule::table('tblinvoiceitems')->where('invoiceid', -1)->where('relid', $serviceId)->delete();
        Capsule::table('tbltrialproducts_peding_trials')->where('serviceid', $serviceId)->delete();
    }
});

$genInvoiceFor = false;

add_hook('InvoicePaid', 100, function($vars) use (&$genInvoiceFor) {
    try {

        Capsule::connection()->setFetchMode(PDO::FETCH_OBJ);

        // get order
        // $order = Capsule::table('tblorders')->where('invoiceid', $vars['invoiceid'])->first();

        // get services
        $hostings = Capsule::table('tblinvoiceitems')->where('invoiceid', $vars['invoiceid'])->where('type', 'Hosting')->get();
        $hostings = Capsule::table('tblhosting')
            ->whereIn('id', array_map(function($row) { return $row->relid; }, $hostings))
            ->get();

        foreach ($hostings as $hosting) {
            if ($hostings->is_trial) {
                run_hook('GetResponseTrialPaid', [
                    'service' => $hosting
                ]);
                continue;
            }

            $options = Capsule::table('tblcustomfields')->where('relid', $hosting->packageid)->where('fieldname', 'trial')->first();

            // check if this product is trial
            if(!is_null($options)) {
                $clientid = $hosting->userid;

                // calculate amount for continue product
                $amount = Capsule::table('tblcustomfieldsvalues')->where('fieldid', $options->id)
                    ->where('relid', $hosting->id)->first();
                $exist = Capsule::table('tblhosting')->where('is_trial', 1)
                    ->where('userid', $clientid)
                    ->where('packageid', $hosting->packageid)
                    ->first();

                // check exist this trial product from the user
                if(is_null($exist) and $amount and $amount->value) {

                    // calc next due date
                    $date = trialProductsCalcDate((int)$hosting->packageid);

                    $emailId = Util::getClientEmailId($clientid);

                    if(!$emailId)
                        logActivity("Warning: client #$clientid have no PPBA set, but have a trial service #{$hosting->id} set");

                    // update amount of the product and set this product as a trial
                    Capsule::table('tblhosting')
                        ->where('id', $hosting->id)
                        ->update([
                            'amount'             => $amount->value,
                            'firstpaymentamount' => Util::getTrialProductPrice(), // probably no need to update this?
                            'is_trial'           => 1,
                            'nextinvoicedate'    => $date,
                            'nextduedate'        => $date,
                            'payeremailid'       => $emailId
                        ]);

                    // update recurring price for other products in this qty
                    Capsule::table('tblhosting')
                        ->where('orderid', $hosting->orderid)->where('firstpaymentamount', $hosting->firstpaymentamount)
                        ->where('amount', $hosting->amount)->where('billingcycle', $hosting->billingcycle)
                        ->where('packageid', $hosting->packageid)->where('is_trial', 0)
                        ->update(['amount' => $amount->value, 'firstpaymentamount' => $amount->value]);

                    // generate invoice for month after trial period
                    $genInvoiceFor = $hosting->id;

                    Util::removePromo($hosting->id);

                    run_hook('GetResponseTrialPurchased', [
                        'service' => $hosting
                    ]);
                }

            }

        }

    } catch (Exception $e) {

        logActivity('Error in "Trial Products" module! Please contact with developer. Error message - "'. $e->getMessage() .'"');

    }

});

add_hook('ProxyOrderCreated', 2, function($vars) use (&$genInvoiceFor) {
    if($genInvoiceFor) {
        localAPI('genInvoices', ['serviceids' => [$genInvoiceFor]], trial_products_get_admin_username());
        unset($genInvoiceFor);
    }
});

add_hook('LogTransaction', 2, function($vars) {
    if (!(in_array($vars['gateway'], ['PayPal Billing Agreement', 'MyWorks Paypal Billing Module']) && $vars['result'] === 'Notify')) {
        return;
    }

    preg_match('/mp_id => (\S*)/', $vars['data'], $matches);

    if (!$matches[1]) {
        return;
    }

    $clientId = Capsule::table('mod_paypalbilling')->where('paypalbillingid', $matches[1])->value('id');

    if (!empty(($pendingTrials = Capsule::connection()->select(
        'SELECT pt.*, h.packageid, h.orderid FROM tbltrialproducts_peding_trials pt
        JOIN tblhosting h ON h.id = pt.serviceid
        WHERE pt.userid = ?', [$clientId])))
    ) {
        foreach ($pendingTrials as $pendingTrial) {
            $realProductId = false;
            if ($result = run_hook('FindTraitProductId', ['id' => $pendingTrial->serviceid])) {
                $realProductId = $result[0]['id'];
            }

            $pid = $realProductId ? $realProductId : $pendingTrial->packageid;

            if (Util::trialPurchaseAllowed($clientId, $pid)) {
                Capsule::connection()->delete(
                    'DELETE FROM `tblinvoiceitems` WHERE invoiceid = -1 AND relid = ?',
                    [$pendingTrial->serviceid]
                );

                Capsule::connection()->update(
                    'UPDATE tblhosting SET firstpaymentamount = 0, is_trial = 1 WHERE id = ?',
                    [$pendingTrial->serviceid]
                );

                Capsule::connection()->delete(
                    'DELETE FROM tbltrialproducts_peding_trials WHERE serviceid = ?',
                    [$pendingTrial->serviceid]
                );

                localAPI(
                    'genInvoices',
                    ['serviceids' => [$pendingTrial->serviceid]],
                    trial_products_get_admin_username()
                );

                // next due invoice for period after trial
                localAPI('genInvoices', ['serviceids' => [$pendingTrial->serviceid]], trial_products_get_admin_username());
            } else {
                logActivity('Failed to activate pending trial #' . $pendingTrial->serviceid . '. Reason: ' . Util::getTrialNotAllowedReason($pid));
            }
        }
    }
});

/*add_hook('LogTransaction', 2, function($vars) {

    $adminUsername = trial_products_get_admin_username();

    try {

        Capsule::connection()->setFetchMode(PDO::FETCH_OBJ);

        if(preg_match('/paypal/i', $vars['gateway'])) {

            $gateway_data = trialParsePaymentGatewayData($vars['data']);

            if (!$gateway_data) {
                logActivity('Trial: cannot parse data ' . $vars['data']);
                return true;
            }

            if (
                (empty($gateway_data['payment_status']) or $gateway_data['payment_status'] != 'Completed') and
                true
            ) {
                logActivity('Trial: conditions not met ' . json_encode($gateway_data));

                return true;
            }

            if(empty($gateway_data['txn_id'])) {

                throw new Exception('Not found transaction id');

            }

            if (empty($gateway_data['payer_email'])) {

                throw new Exception('Error while canceled order. Not found payer email. Please manual do it!');

            }

            $email = $gateway_data['payer_email'];

            // get parent transaction
            $transaction = Capsule::table('tblaccounts')->where('transid', $gateway_data['txn_id'])->first();

            // Try to workaround no transaction is found
            if(empty($transaction)) {
                $invoice = Capsule::table('tblinvoices')
                    ->where('id', $gateway_data['custom'])
                    ->where('status', 'Unpaid')
                    ->first();
                if (!empty($invoice)) {
                    $transaction = (object) [
                        'invoiceid' => $invoice->id,
                        'transid' => $gateway_data['txn_id']
                    ];
                }

                if (empty($transaction)) {
                    $found_key = '';
                    foreach (array_keys($gateway_data) as $key) {
                        if (false !== stripos($key, 'Invoice Found')) {
                            $found_key = $key;
                            break;
                        }
                    }

                    if ($found_key and !empty($gateway_data[$found_key])) {
                        $invoice = Capsule::table('tblinvoices')
                            ->where('id', $gateway_data[$found_key])
                            ->where('status', 'Unpaid')
                            ->first();

                        if (!empty($invoice)) {
                            $transaction = (object) [
                                'invoiceid' => $invoice->id,
                                'transid' => $gateway_data['txn_id']
                            ];
                        }
                    }
                }

                // Still empty, throw an exception
                if (empty($transaction)) {
                    throw new Exception("Not found parent transaction \"{$gateway_data['txn_id']}\" in database." .
                        ' ' . json_encode($gateway_data));
                }

            }

            $order = Capsule::table('tblorders')->where('invoiceid', $transaction->invoiceid)->first();

            if(empty($order)) {

                throw new Exception('Not found client order in database. Please manual search order
                 by invoice ID and cancel it, and search services by order ID and suspend them.
                 Invoice ID: ' . $transaction->invoiceid);

            }

            // build query for tblhosting table
            $hostings = Capsule::table('tblhosting')->where('orderid', $order->id)
                ->where('firstpaymentamount', '0.01'); // where is_trial = 1 instead?

            // check existing payer email in db
            $payer_email = Capsule::table('tbltrialproductsemailpayers')->where('payeremail', $email)->first();

            if (is_null($payer_email)) {

                // add new payer email
                $payer_email_id = Capsule::table('tbltrialproductsemailpayers')
                    ->insertGetId(['payeremail' => $email]);

            } else {

                $payer_email_id = $payer_email->id;

            }

            // update payer email id in hostings items
            Capsule::table('tblhosting')->whereIn('id', $hostings->pluck('id'))
                ->update(['payeremailid' => $payer_email_id]);

            // get hostings of the order
            $hostings = $hostings->get();

            $trialExist = false;

            // if exist trial products in order
            if (!empty($hostings)) {

                foreach ($hostings as $hosting) {

                    $checkRepeatTrial = Capsule::table('tblhosting')->where('packageid', $hosting->packageid)
                        ->where('firstpaymentamount', '0.01')->where('payeremailid', $hosting->payeremailid)
                        ->whereNotIn('orderid', [$order->id])->first();

                    if (!is_null($checkRepeatTrial)) {

                        $trialExist = true;
                        break;

                    }

                }

                if($trialExist) {

                    //suspend services
                    $hostings = Capsule::table('tblhosting')->where('orderid', $order->id)
                        ->whereIn('domainstatus', ['Active', 'Completed'])->get();

                    // cancel order and set invoice status is "Refunded"
                    $api_result = localAPI('CancelOrder', ['orderid' => $order->id], $adminUsername);
                    $query_result = Capsule::table('tblinvoices')->where('id', $order->invoiceid)->update(['status' => 'Refunded']);

                    foreach ($hostings as $service) {

                        $postData = [
                            'accountid' => $service->id,
                            'suspendreason' => 'Suspended by reason: Retrying a trial product in order',
                        ];
                        $result = localAPI('ModuleSuspend', $postData, $adminUsername);
                        if($result['result'] = 'success') {

                            logActivity('Suspended Product. Service ID: ' . $service->id .
                                ' in Order ID: ' . $order->id . ' , Invoice ID: ' . $transaction->invoiceid . ' .
                                 Reason: Retrying a trial product in order');

                        }

                    }

                    $ban_result = addPayerEmailToBan($email);

                    if($ban_result->status != 'success') {

                        logActivity('Error in "Trial Products" module.
                        Error while adding email to ban list. Please manual do it! Email - ' . $email . '. Response - ' . json_encode($ban_result));

                    }

                    // refund payment
                    $refund_result = trial_products_refund($transaction->transid, $order, $vars, $adminUsername);

                    if(!$refund_result) {

                        logActivity('Error in "Trial Products" module. Not refund payment. Please manual do it!
                                Order ID: ' . $order->id . ' . Invoice ID: ' . $transaction->invoiceid);

                    }

                    // if order canceled
                    if ($api_result['result'] == 'success' and $query_result) {

                        // send email to user
                        $email_template = Capsule::table('tbladdonmodules')->where('module', 'trial_products')
                            ->where('setting', 'messagename')->value('value');

                        if (!empty($email_template)) {

                            $postData = [
                                'messagename' => $email_template,
                                'id' => $order->userid,
                            ];
                            logActivity('Trial: sending email ' . json_encode($postData));
                            $api_result = localAPI('SendEmail', $postData, $adminUsername);

                            if ($api_result['result'] == 'error') {

                                // save activity log
                                logActivity('Error while sending email in "Trial Products" module. Error message - ' . $api_result['message']);

                            }

                        } else {

                            logActivity('Error while sending email in "Trial Products" module. Error message -
                    you not setted email template in config of module');

                        }

                        // save activity log
                        logActivity('"Trial Products" module. Payer PayPal email - ' . $email . ' have trial product of
                        this type on the other account.
                     Order Cancelled & Refunded Successfully! Order ID: ' . $order->id);

                    } else {

                        logActivity('"Trial Products" module. Not canceled Order ID: ' . $order->id . ' . Please manual cancel order!');

                    }

                }

            }

        }

    } catch (Exception $e) {

        logActivity('Error in "Trial Products" module. Error message - ' . $e->getMessage()
            . ' ' . $e->getFile() . ':' . $e->getLine() . ' ' . $e->getTraceAsString());

    }

});*/

/**
 * Calculate new due date for product
 *
 * @param $relid|int
 * @return DateTime|string
 */
function trialProductsCalcDate($relid) {

    // get free period value
    $days = trialProductsGetFreePeriod($relid);

    $date = new \DateTime();

    // calc next duedate
    $date->modify('+' . $days . ' days');

    $date = $date->format('Y-m-d');

    return $date;

}

/**
 * Calculate next due amount for this product
 *
 * @param $billingcycle|string
 * @param $price|object
 * @return float
 */
function trialProductsCalcNextAmount($billingcycle, $price, $setupfee = false) {

    $amount = 0;

    switch ($billingcycle) {

        case 'One Time':
            $amount = (float)$price->monthly + ($setupfee ? (float)$price->msetupfee : 0);
            break;

        case 'Monthly':
            $amount = (float)$price->monthly + ($setupfee ? (float)$price->msetupfee : 0);
            break;

        case 'Quarterly':
            $amount = (float)$price->quarterly + ($setupfee ? (float)$price->qsetupfee : 0);
            break;

        case 'Semi-Annually':
            $amount = (float)$price->semiannually + ($setupfee ? (float)$price->ssetupfee : 0);
            break;

        case 'Annually':
            $amount = (float)$price->annually + ($setupfee ? (float)$price->asetupfee : 0);
            break;

        case 'Biennially':
            $amount = (float)$price->biennially + ($setupfee ? (float)$price->bsetupfee : 0);
            break;

        case 'Triennially':
            $amount = (float)$price->triennially + ($setupfee ? (float)$price->tsetupfee : 0);
            break;

    }

    return (float)$amount;

}

/**
 * Get free period days count
 *
 * @param $relid|int
 * @return int
 */
function trialProductsGetFreePeriod($relid) {

    // get free period value
    $free_period = Capsule::table('tblcustomfields')->where('relid', $relid)
        ->where('fieldname', 'free_period')->first();

    // calc trial days
    if(empty($free_period->fieldoptions)) {

        $days = 5;

    } else {

        $days = explode(',', $free_period->fieldoptions);
        $days = $days[0];

    }

    return (int)$days;

}

/**
 * Get admin username for using WHMCS API
 *
 * @return mixed
 * @throws Exception
 */
function trial_products_get_admin_username() {

    $adminUsername = Capsule::table('tbladmins')->where('disabled', 0)->where('roleid', 1)->first();

    if(empty($adminUsername)) {

        throw new Exception('No find admins in database!');

    }

    return $adminUsername->username;

}

function trialParsePaymentGatewayData($string) {
    $data = [];
    foreach (explode("\n", $string) as $line) {
        if (preg_match('~^(.+)\s+=>\s+(.+)$~', $line, $parsed)) {
            $data[trim($parsed[1])] = trim($parsed[2]);
        }
    }

    return $data;
}

/**
 * Add email to ban list
 *
 * @param $email
 * @return mixed
 */
function addPayerEmailToBan($email)
{

    $data = [
        'user_email' => $email,
        'description' => 'Retrying a trial product',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://guardian.blazing.and-life.in/api/add_to_ban");
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
    curl_setopt($ch, CURLOPT_TIMEOUT, 7);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);

    return json_decode($response);

}

/**
 * @param string $transaction
 * @param object $order
 * @param array $vars
 * @param string $adminUsername
 * @return bool
 */
function trial_products_refund($transaction, $order, $vars, $adminUsername) {
    /*$result = refundInvoicePayment($transaction, 0, true, false, true, '');

    if ($result == 'manual') {
        logActivity("\"Trial Products\" module. It says you should manually refund the transaction \"$transaction\"");

        return false;
    }
    elseif ($result == 'success') {
        return true;
    }
    else {
        logActivity("\"Trial Products\" module. Refund status for transaction \"$transaction\" is \"$result\"");

        return false;
    }*/

    // get PayPal sandbox setting
    $environment = Capsule::table('tbladdonmodules')->where('module', 'trial_products')
        ->where('setting', 'sandbox')->value('value');
    $environment = ($environment == 'on' ? '.sandbox' : '');

    $paypal_user = Capsule::table('tblpaymentgateways')->where('gateway', 'paypalbilling')
        ->where('setting', 'API_USERNAME')->value('value');

    $paypal_password = Capsule::table('tblpaymentgateways')->where('gateway', 'paypalbilling')
        ->where('setting', 'API_PASSWORD')->value('value');

    $paypal_signature = Capsule::table('tblpaymentgateways')->where('gateway', 'paypalbilling')
        ->where('setting', 'API_SIGNATURE')->value('value');

    $data = [
        'USER'          => $paypal_user,
        'PWD'           => $paypal_password,
        'SIGNATURE'     => $paypal_signature,
        'METHOD'        => 'RefundTransaction',
        'VERSION'       => '94',
        'TRANSACTIONID' => $transaction,
        'REFUNDTYPE'    => 'Full',
    ];

    // call PayPal API
    $paypal_result = curlCall("https://api-3t" . $environment . ".paypal.com/nvp", $data);

    // array of new transaction
    $newtrx = [];

    // get refund transaction id
    preg_match('/REFUNDTRANSACTIONID=([^\s&]*)/i', $paypal_result, $paypal_response);

    if (!empty($paypal_response[1])) {

        $newtrx['id'] = $paypal_response[1];

    }

    // get refund amount
    preg_match('/TOTALREFUNDEDAMOUNT=([^\s&]*)/i', $paypal_result, $paypal_response);

    if (!empty($paypal_response[1])) {

        $newtrx['amount'] = str_replace('%2e', '.', $paypal_response[1]);

    }

    // get refund result
    preg_match('/ACK=([^\s&]*)/i', $paypal_result, $paypal_response);

    if (!empty($paypal_response[1])) {

        $newtrx['result'] = $paypal_response[1];

        if ($newtrx['result'] == 'Success') {

            // saving transaction
            $postData = [
                'paymentmethod' => $vars['gateway'],
                'userid'        => $order->userid,
                'invoiceid'     => $order->invoiceid,
                'transid'       => $newtrx['id'],
                'date'          => date('Y-m-d H:i:s'),
                'description'   => 'Refund of Transaction ID ' . $transaction,
                'amountout'     => $newtrx['amount'],
                'rate'          => '1.00000',
            ];

            $results = localAPI('AddTransaction', $postData, $adminUsername);

            // only for standard PayPal gateway
            if($results['result'] = 'success' and $vars['gateway'] == 'PayPal') {

                logTransaction($vars['gateway'], $paypal_result, 'Refunded');

            }

            return true;

        } else {

            return false;

        }

    }

    return false;
}

add_hook('ProxyServiceBeforeUpgrade', 2, function($vars) {
    $serviceId = $vars['serviceid'];
    if(Util::isTrialNotEnded($serviceId)) {
        Util::setDueDateAndRecurAmountForFullPriceUpgrade($serviceId);
    }
});

add_hook('ProxyServiceAfterUpgrade', 2, function($vars) {
    $serviceId = $vars['serviceid'];

    if($amount = Util::restoreDueDateAndRecurAmount($serviceId)) {

        Capsule::connection()
            ->update(
                "UPDATE `tblupgrades` SET `recurringchange` = recurringchange-? WHERE `tblupgrades`.`orderid` = ?",
                [$amount, $vars['orderid']]);
    }
});

$preventEmailSendingAndCancelInvoices = false;

add_hook('InvoicePaidPreEmail'/*'InvoicePaid'*/, 1, function($vars) use (&$preventEmailSendingAndCancelInvoices) {
    if($res = Capsule::connection()
    ->selectOne('SELECT ii.*, tblupgrades.relid as serviceid FROM `tblinvoiceitems` ii
        JOIN tblupgrades ON tblupgrades.id = ii.relid WHERE ii.invoiceid = ? AND ii.type = \'Upgrade\'', [$vars['invoiceid']])
    ) {
        $serviceId = $res->serviceid;
        if(Util::isTrialNotEnded($serviceId)) {
            $preventEmailSendingAndCancelInvoices = true;
        }
    }
});

add_hook('EmailPreSend', 1, function($vars) use (&$preventEmailSendingAndCancelInvoices) {
    if($preventEmailSendingAndCancelInvoices && $vars['messagename'] == 'Invoice Created') {
        return ['abortsend' => true];
    }
});

add_hook('ProxyServiceBeforeRecurringInvoiceRegeneration', 2, function($vars) use (&$preventEmailSendingAndCancelInvoices) {
    $serviceId = $vars['serviceid'];
    if(!$preventEmailSendingAndCancelInvoices)
        return false;

    Capsule::connection()->update('UPDATE `tblhosting` SET `nextduedate` = DATE_ADD(curdate(), INTERVAL 1 MONTH) WHERE `id` = ?', [$serviceId]);

    $invoices = Capsule::connection()->select("SELECT
            i.id, ii.amount, i.status
        FROM tblinvoiceitems ii
        INNER JOIN tblinvoices i ON ii.type = 'Hosting' AND ii.invoiceid = i.id
        WHERE ii.relid = ? AND i.status = 'Unpaid'
        ORDER BY ii.id DESC", [$serviceId]);

    foreach($invoices as $invoice) {
        Capsule::connection()->update('UPDATE tblinvoices SET status = "Cancelled", notes = "Cancelled by free_trials plugin" WHERE id = ?', [$invoice->id]);
    }
});

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
