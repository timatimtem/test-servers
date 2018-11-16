<?php

namespace WHMCS\Module\Blazing\Servers;

use WHMCS\Module\Blazing\Servers\Vendor\WHMCS\Module\Framework\Addon;

class Logger
{

    protected $logger;
    protected $sharedIndex = [];

    public static function err($message, array $context = [], array $index = [])
    {
        self::getInstance()->logger->err($message, $context, $index);
    }

    public static function warn($message, array $context = [], array $index = [])
    {
        self::getInstance()->logger->warn($message, $context, $index);
    }

    public static function notice($message, array $context = [], array $index = [])
    {
        self::getInstance()->logger->notice($message, $context, $index);
    }

    public static function info($message, array $context = [], array $index = [])
    {
        self::getInstance()->logger->info($message, $context, $index);
    }

    public static function debug($message, array $context = [], array $index = [])
    {
        self::getInstance()->logger->debug($message, $context, $index);
    }

    public static function bindUserId($userId)
    {
        self::getInstance($userId);
    }

    public static function shareIndex($key, $value)
    {
        self::getInstance()->logger->addSharedIndex($key, $value);
    }

    public static function unshareIndex($key)
    {
        self::getInstance()->logger->removeSharedIndex($key);
    }

    public static function prepareMasterRequestParameter()
    {
        return self::getInstance()->logger->prepareMasterRequestParameter();
    }

    public static function setMasterRequestUid($uid)
    {
        return self::getInstance()->logger->setMasterRequestUid($uid);
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public static function getInstance($userId = 0)
    {
        static $instance;

        if (!$instance) {
            $instance = new self($userId);
        }

        if ($userId) {
            $instance->logger->addSharedIndex('userId', $userId);
        }

        return $instance;
    }

    protected function __construct($userId = 0)
    {
        /** @var Addon $module */
        $module = Addon::getInstanceById('blazing_servers');

        $this->logger = \WHMCS\Module\Blazing\Servers\Vendor\Blazing\Logger\Logger::createRotatingFileLogger(
            str_replace('{user}', $userId, $module->getOriginalConfig('config.logPath')),
            5
        );
        $this->logger->configureAppEnvProcessor(__DIR__ . '/../composer.json');
    }
}
