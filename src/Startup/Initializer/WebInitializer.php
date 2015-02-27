<?php namespace buildr\Startup\Initializer;

use buildr\Loader\classLoader;
use buildr\Registry\Registry;
use buildr\Startup\BuildrEnvironment;
use \buildr\Startup\Initializer\InitializerInterface;
use Patchwork\Utf8\Bootup;

/**
 * BuildR - PHP based continuous integration server
 *
 * Initializer class for web requests
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Startup\Initializer
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class WebInitializer extends BaseInitializer implements InitializerInterface {

    /**
     * Run the startup initialization process
     *
     * @param string $basePath
     * @param \buildr\Loader\classLoader $autoloader
     * @return bool
     */
    public function initialize($basePath, classLoader $autoloader) {
        //Initialize Patchwork-UTF8 mbstring library
        Bootup::initMbstring();

        //Environment detection
        BuildrEnvironment::detectEnvironment();
        $environment = BuildrEnvironment::getEnv();

        //Set up the environment in the registry
        Registry::setVariable('buildr.environment.protected', $environment);

        $this->registerServiceProviders();
    }
}
