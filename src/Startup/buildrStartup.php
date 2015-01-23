<?php namespace buildr\Startup;

use buildr\Config\Config;
use buildr\ServiceProvider\ServiceProvider;
use buildr\Logger\Facade\Logger;

/**
 * BuildR - PHP based continuous integration server
 *
 *
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Registry
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class buildrStartup {

    /**
     * @type flaot
     */
    private static $startupTime;

    public static function doStartup() {
        self::$startupTime = microtime(true);

        $serviceProviders = Config::get("registry.serviceProviders");
        ServiceProvider::registerProvidersByArray($serviceProviders);

        Logger::log("Message");

    }

    /**
     * @return float
     */
    public static function getStartupTime() {
        return self::$startupTime;
    }

    private static function bindInstallPath() {

    }

    public static function initialize() {
        self::checkBuildrUtilLibrary();
    }

    private static function checkBuildrUtilLibrary() {

    }
}