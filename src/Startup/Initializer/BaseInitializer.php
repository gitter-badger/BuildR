<?php namespace buildr\Startup\Initializer;

use buildr\Config\Config;
use buildr\Loader\classLoader;
use buildr\Startup\Initializer\InitializerInterface;
use buildr\ServiceProvider\ServiceProvider;

/**
 * BuildR - PHP based continuous integration server
 *
 * Base initializer
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Startup\Initializer
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @codeCoverageIgnore
 */
class BaseInitializer implements InitializerInterface {

    /**
     * Run the startup initialization process
     *
     * @param string $basePath
     * @param \buildr\Loader\classLoader $autoloader
     * @return bool
     */
    public function initialize($basePath, classLoader $autoloader) {
        $this->registerServiceProviders();
    }

    /**
     * Register the service providers in the registry
     */
    protected function registerServiceProviders() {
        $serviceProviders = Config::getProviderConfig();
        ServiceProvider::registerProvidersByArray($serviceProviders);
    }
}
