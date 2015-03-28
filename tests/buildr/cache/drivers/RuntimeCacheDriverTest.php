<?php namespace buildr\cache\drivers;

use buildr\Cache\Driver\RuntimeCacheDriver;
use buildr\tests\cache\drivers\AbstractCacheDriver;

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