<?php namespace buildr\Startup;

use buildr\Config\Config;
use buildr\Loader\classMapClassLoader;
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

    /**
     * @type \buildr\Loader\classLoader
     */
    private static $loader;

    public static function doStartup($basePath) {
        //Set the startup time, to debug processing time
        self::$startupTime = microtime(true);

        //Initialize autoloading
        self::initializeAutoloading($basePath);

        //Initialize Patchwork/utf8 mbstring replacement
        Bootup::initMbstring();

        //Bind installation paths to registry
        self::bindInstallPath();

        //Environment detection and registration
        $environment = buildrEnvironment::getEnv();
        Registry::setVariable('buildr.environment.protected', $environment);

        //Registering services to registry by configuration
        $serviceProviders = Config::get("registry.serviceProviders");
        ServiceProvider::registerProvidersByArray($serviceProviders);

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
        self::$loader = new \buildr\Loader\classLoader();

        //PSR4
        $PSR4Loader = new \buildr\Loader\PSR4ClassLoader();
        $sourceAbsolute = realpath($basePath . DIRECTORY_SEPARATOR . 'src') . DIRECTORY_SEPARATOR;
        $PSR4Loader->registerNamespace('buildr\\', $sourceAbsolute);

        //ClassMap
        $classMapLoader = new classMapClassLoader();
        $classMapLoader->registerFile(realpath($basePath . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Utils' . DIRECTORY_SEPARATOR . 'Debug' . DIRECTORY_SEPARATOR . 'DebugHelper.php'));

        self::$loader->registerLoader($PSR4Loader);
        self::$loader->registerLoader($classMapLoader);
        self::$loader->initialize();

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
     * Returns the main instance of the autoloader
     *
     * @return \buildr\Loader\classLoader
     */
    public static final function getAutoloader() {
        return self::$loader;
    }

    private static function bindInstallPath() {

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
    public static final function getTimeSinceStartup() {
        $currentTime = microtime(TRUE);
        return $currentTime - self::getStartupTime();
    }


}