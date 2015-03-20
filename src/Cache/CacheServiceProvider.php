<?php namespace buildr\Cache;

use buildr\Config\Config;
use \buildr\Cache\CacheDriverInterface;
use buildr\ServiceProvider\ServiceProviderInterface;

/**
 * BuildR - PHP based continuous integration server
 *
 * Cache service provider
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Cache
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class CacheServiceProvider implements ServiceProviderInterface {

    /**
     * Returns an object that be registered to registry
     *
     * @return Object
     */
    public function register() {
        $driverName = Config::getMainConfig()['cache']['driver'];
        $driverClass = new $driverName;

        if(!($driverClass instanceof CacheDriverInterface)) {
            throw new \InvalidArgumentException("The cache driver ({$driverName}) not implements the CacheInterface!");
        }

        return $driverClass;

    }

    /**
     * Returns the binding name in the registry
     *
     * @return string
     */
    public function getBindingName() {
        return 'cache';
    }
}
