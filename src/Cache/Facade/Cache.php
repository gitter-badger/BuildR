<?php namespace buildr\Cache\Facade;

use buildr\Facade\Facade;

/**
 * Cache facade
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Cache\Facade
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @codeCoverageIgnore
 *
 * @method static \buildr\Cache\CacheItemInterface get(string $key, $defaultValue = NULL) Returns a cache entry from the driver
 * @method static bool set(string $key, mixed $value, int $ttl = 30) Store an entry in the cache
 * @method static bool function exist(string $key) Return the existence of the given key
 * @method static int getHitCount() Return the cache hit count
 * @method static int getMissCount() Return the cache miss count
 * @method static array getStats() Return an array filled with statistics data of the current driver
 * @method static int getMaxTTL() Returns the maximum TTL of an entry, supported by this driver
 * @method static int getMaxKeyCount() Return the maximum key count that driver can store at one session 0 means it support unlimited key
 */
class Cache extends Facade {

    public function getBindingName() {
        return 'cache';
    }
}
