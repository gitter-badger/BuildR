<?php namespace buildr\Config\Source;

use \buildr\Registry\Registry;
use buildr\Config\Selector\ConfigSelector;

/**
 * BuildR - PHP based continuous integration server
 *
 * 
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Config\Source
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
abstract class CachedConfigSource extends ConfigSource implements CachedConfigSourceInterface {

    /**
     * Generate a cacheKey for a ConfigSelector
     *
     * @param \buildr\Config\Selector\ConfigSelector $selector
     * @return string
     */
    public function getCacheKeyForSelector(ConfigSelector $selector) {
        return "CONFIG_" . strtoupper($this->getEnvironmentName()) . strtoupper(md5($selector->getOriginalSelector()));
    }


    /**
     * Return the current cache driver
     *
     * @return \buildr\Cache\CacheDriverInterface
     */
    public function getCache() {
        return Registry::getClass('cache');
    }
}
