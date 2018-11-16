# "Trial Products" Module for WHMCS #

## Attention ##
OUTDATED. BUG DISCOVERED ON MAY 19TH. One-time fee needs to be charged instead of monthly, for the trial period. See Skype chat.

## About ##

This addon allows you to sell trial products with a custom time trial time.
If the user wants to re-order the trial product, he can buy it by full price.

** To make the product trial, you need to add 2 custom fields to your product: **

 A. The first field is "trial". Field Type - "Text Box" and tick "Admin Only" checkbox.

 B. The second field is "free_period". Field Type - "Drop Down" and check "Admin Only" checkbox. Enter you days count of free period on this product/service to "Select Options" input or module will set to standard 5 days free period.

** First phase: **
During the ordering process, the cost of trial products is 0.01. This price using for check existing PayPal payer email process in ban list base.
If you already have such a trial product - it will display the real price.

** Second phase: **
After invoice is paid - the module changes the next payment time for the today + (30 days * quantity months of billing cycle) and set real due price.

## About ##

* Version: 0.8
* Author: Ruslan Ivanov
* Date: April 2017

## How do set up ##

1. Put folder "trial_products" to {YOU WHMCS PATH}/modules/addons/.

2. In admin panel on top menu click "Setup" and click "Addon Modules". Find "Trial Products" module and click green "Activate" button. After module activating click button "Configure" and checked Full Administrator checkbox. And if you use sanbdox mode of PayPal please tick checkbox.

3. In admin panel on top menu click "Addons" and click "Trial Products". Use module functional.

Thx for using!