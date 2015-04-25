<?php namespace buildr\Cache;

/**
 * Common interface for cache drivers
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Cache
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface CacheDriverInterface {

    /**
     * Returns a cache entry from the driver
     *
     * @param string $key
     * @param mixed $defaultValue
     *
     * @return \buildr\Cache\Item\CacheItemInterface
     */
    public function get($key, $defaultValue = NULL);

    /**
     * Store an entry in the cache
     *
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     *
     * @return bool
     */
    public function set($key, $value, $ttl = 30);

    /**
     * Return the existence of the given key
     *
     * @param string $key
     *
     * @return bool
     */
    public function exist($key);

    /**
     * Return the cache hit count
     *
     * @return int
     */
    public function getHitCount();

    /**
     * Return the cache miss count
     *
     * @return int
     */
    public function getMissCount();

    /**
     * Return an array filled with statistics data of the current driver
     *
     * @return array
     */
    public function getStats();

    /**
     * Returns the maximum TTL of an entry, supported by this driver
     *
     * @return int
     */
    public function getMaxTTL();

    /**
     * Return the maximum key count that driver can store at one session
     * 0 means it support unlimited key
     *
     * @return int
     */
    public function getMaxKeyCount();

}
