<?php namespace buildr\cache\drivers;

use buildr\Cache\Driver\RuntimeCacheDriver;
use buildr\tests\cache\drivers\AbstractCacheDriver;

/**
 * Runtime cache driver tests
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Cache\Drivers
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class RuntimeCacheDriverTest extends AbstractCacheDriver {

    /**
     * returns the correctly configured driver, we want to test
     *
     * @return \buildr\Cache\CacheDriverInterface
     */
    protected function setUpDriver() {
        return new RuntimeCacheDriver();
    }


}