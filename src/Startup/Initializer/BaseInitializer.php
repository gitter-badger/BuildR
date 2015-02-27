<?php namespace buildr\Startup\Initializer;

use buildr\Config\Config;
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
 */
class BaseInitializer {

    protected function registerServiceProviders() {
        $serviceProviders = Config::get("registry.serviceProviders");
        ServiceProvider::registerProvidersByArray($serviceProviders);
    }
}
