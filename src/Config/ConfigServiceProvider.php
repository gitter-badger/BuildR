<?php namespace buildr\Config;

use buildr\Config\Source\PHPConfigSource;
use buildr\ServiceProvider\ServiceProviderInterface;

/**
 * BuildR - PHP based continuous integration server
 *
 * Configuration service provider
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Config
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @codeCoverageIgnore
 */
class ConfigServiceProvider implements ServiceProviderInterface {

    /**
     * Returns an object that be registered to registry
     *
     * @return Object
     */
    public function register() {
        $mainSource = new PHPConfigSource();

        return new Config($mainSource);
    }

    /**
     * Returns the binding name in the registry
     *
     * @return string
     */
    public function getBindingName() {
        return 'config';
    }
}
