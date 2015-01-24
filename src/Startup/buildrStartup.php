<?php namespace buildr\Startup;

use buildr\Config\Config;
use buildr\Registry\Registry;
use buildr\ServiceProvider\ServiceProvider;
use buildr\Logger\Facade\Logger;
use Patchwork\Utf8\Bootup;

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
        //Set the startup time, to debug processing time
        self::$startupTime = microtime(true);

        //Initialize Patchwork/utf8 mbstring replacement
        Bootup::initMbstring();

        //Environment detection and registration
        $environment = buildrEnvironment::detetcEnvironment();
        Registry::setVariable('buildr.environment.protected', $environment);

        $serviceProviders = Config::get("registry.serviceProviders");
        ServiceProvider::registerProvidersByArray($serviceProviders);

        

    }

    /**
     * Return the startup time in microseconds
     *
     * @return float
     */
    public static function getStartupTime() {
        return self::$startupTime;
    }

    /**
     * Get time since startup in microseconds
     *
     * @return float
     */
    private static final function getTimeSinceStartup() {
        $currentTime = microtime(TRUE);
        return $currentTime - self::getStartupTime();
    }

    private static function bindInstallPath() {

    }

    public static function initialize() {
        self::checkBuildrUtilLibrary();
    }

    private static function checkBuildrUtilLibrary() {

    }
}