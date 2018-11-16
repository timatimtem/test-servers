<?php

namespace WHMCS\Module\Blazing\Servers\Events;

use WHMCS\Module\Blazing\Servers\Vendor\WHMCS\Module\Framework\Events\AbstractHookListener;

class TrialPricingOverrode extends AbstractHookListener
{
    protected $name = 'TrialPricingOverrode';

    protected static $pendingTrial;
    protected static $priceOverrode;
    protected static $reason;

    protected function execute(array $args = null)
    {
        self::$priceOverrode = $args['trial'];
        self::$pendingTrial = $args['pendingTrial'];

        if(!$args['trial']) {
            self::$reason = isset($args['reason']) ? $args['reason'] : '';
        }
    }

    public static function trackOverride()
    {
        self::$reason = '';
        self::$pendingTrial = false;
        self::$priceOverrode = false;
    }

    public static function isOverrode()
    {
        return self::$priceOverrode;
    }

    public static function isPendingTrial()
    {
        return self::$pendingTrial;
    }

    public static function getNotAllowedReason()
    {
        return self::$reason;
    }
}