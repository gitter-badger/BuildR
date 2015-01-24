<?php namespace buildr\Startup;

use buildr\Config\Config;
use buildr\Logger\Facade\Logger;
use buildr\Registry\Registry;
use buildr\ServiceProvider\ServiceProvider;
use buildr\Utils\String\StringUtils;
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

    public static function doStartup($basePath) {
        //Set the startup time, to debug processing time
        self::$startupTime = microtime(true);

        //Initialize autoloading
        self::initializeAutoloading($basePath);

        //Initialize Patchwork/utf8 mbstring replacement
        Bootup::initMbstring();

        //Environment detection and registration
        $environment = buildrEnvironment::detectEnvironment();
        Registry::setVariable('buildr.environment.protected', $environment);

        $serviceProviders = Config::get("registry.serviceProviders");
        ServiceProvider::registerProvidersByArray($serviceProviders);

        Logger::log("my message");

    }

    /**
     * @param bool $withComposer
     */
    public static final function initializeAutoloading($basePath, $withComposer = TRUE) {
        //System-safe absolute path generation
        $classLoaderLocation = [$basePath, 'src', 'Loader', 'classLoader.php'];
        $classLoaderLocation = implode(DIRECTORY_SEPARATOR, $classLoaderLocation);
        $classLoaderLocation = realpath($classLoaderLocation);

        //Load classLoader
        require_once $classLoaderLocation;

        //Initialize and set-up autoloading
        \buildr\Loader\classLoader::loadAutoLoader();
        $loader = new \buildr\Loader\classLoader();

        $PSR4Loader = new \buildr\Loader\PSR4ClassLoader();
        $sourceAbsolute = realpath($basePath . DIRECTORY_SEPARATOR . 'src') . DIRECTORY_SEPARATOR;
        $PSR4Loader->registerNamespace('buildr\\', $sourceAbsolute);

        $loader->registerLoader($PSR4Loader);
        $loader->initialize();

        //If we need composer autoloader, try to include it
        if($withComposer === TRUE) {
            //Loading composer's autolaoder, we must to use it, because some package not provide proper autolaoder
            $composerLoaderLocation = [$basePath, 'vendor', 'autoload.php'];
            $composerLoaderLocation = implode(DIRECTORY_SEPARATOR, $composerLoaderLocation);
            $composerLoaderLocation = realpath($composerLoaderLocation);

            if(file_exists($composerLoaderLocation)) {
                //Load classLoader
                require_once $composerLoaderLocation;
            }
        }
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
}