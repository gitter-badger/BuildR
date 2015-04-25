<?php namespace buildr\Config\Source;

use buildr\Config\Selector\ConfigSelector;

/**
 * Interface for cache-enabled config sources
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Config
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface CachedConfigSourceInterface {

    /**
     * Return the current cache driver
     *
     * @return \buildr\Cache\CacheDriverInterface
     */
    public function getCache();

    /**
     * Generate a cacheKey for a ConfigSelector
     *
     * @param \buildr\Config\Selector\ConfigSelector $selector
     *
     * @return string
     */
    public function getCacheKeyForSelector(ConfigSelector $selector);

}
