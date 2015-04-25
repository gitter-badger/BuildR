<?php namespace buildr\Cache\Driver;

use buildr\Cache\CacheDriverInterface;
use buildr\Cache\Item\CacheItem;

/**
 * Runtime (Lifetime based) cache driver
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Cache\Driver
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class RuntimeCacheDriver implements CacheDriverInterface {

    private $hitRate = 0;

    private $missRate = 0;

    private $cache = [];

    /**
     * Returns a cache entry from the driver
     *
     * @param string $key
     * @param mixed $defaultValue
     *
     * @return \buildr\Cache\Item\CacheItemInterface
     */
    public function get($key, $defaultValue = NULL) {
        if(isset($this->cache[$key])) {
            $this->hitRate++;

            return new CacheItem($key, $this->cache[$key], TRUE);
        }

        $this->missRate++;

        return new CacheItem($key, $defaultValue, FALSE);
    }

    /**
     * Store an entry in the cache
     *
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     *
     * @return bool
     */
    public function set($key, $value, $ttl = 30) {
        $this->cache[$key] = $value;
    }

    /**
     * Return the existence of the given key
     *
     * @param string $key
     *
     * @return bool
     */
    public function exist($key) {
        return ($this->get($key)->isHit() === TRUE) ? TRUE : FALSE;
    }

    /**
     * Return the cache hit count
     *
     * @return int
     */
    public function getHitCount() {
        return $this->hitRate;
    }

    /**
     * Return the cache miss count
     *
     * @return int
     */
    public function getMissCount() {
        return $this->missRate;
    }

    /**
     * Return an array filled with statistics data of the current driver
     *
     * @return array
     */
    public function getStats() {
        return [
            'hits' => $this->hitRate,
            'misses' => $this->missRate,
            'count' => count(array_keys($this->cache)),
        ];
    }

    /**
     * Returns the maximum TTL of an entry, supported by this driver
     *
     * @return int
     */
    public function getMaxTTL() {
        return 0;
    }

    /**
     * Return the maximum key count that driver can store at one session
     * 0 means it support unlimited key
     *
     * @return int
     */
    public function getMaxKeyCount() {
        return 0;
    }
}
