<?php namespace buildr\tests\cache\drivers;

use buildr\Cache\Item\CacheItemInterface;
use buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Abstract cache driver tester class
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
abstract class AbstractCacheDriver extends BuildRTestCase {

    const TEST_KEY = "TEST_CACHE_KEY";

    const TEST_VALUE = "testValue";

    /**
     * @type \buildr\Cache\CacheDriverInterface
     */
    private $driver;

    /**
     * returns the correctly configured driver, we want to test
     *
     * @return \buildr\Cache\CacheDriverInterface
     */
    protected abstract function setUpDriver();

    /**
     * Return a single instance from the current cache driver
     *
     * @return \buildr\Cache\CacheDriverInterface
     */
    public function getDriver() {
        if($this->driver === NULL) {
            $this->driver = $this->setUpDriver();
            $this->driver->set(SELF::TEST_KEY, SELF::TEST_VALUE);
        }

        return $this->driver;
    }

    public function testMaxTTLIsInteger() {
        $this->assertTrue(is_int($this->getDriver()->getMaxTTL()));
    }

    public function testMaxKeyIsInteger() {
        $this->assertTrue(is_int($this->getDriver()->getMaxKeyCount()));
    }

    public function testHitCountIsInteger() {
        $this->assertTrue(is_int($this->getDriver()->getHitCount()));
    }

    public function testMissCountIsInteger() {
        $this->assertTrue(is_int($this->getDriver()->getMissCount()));
    }

    public function testDidReturnStatisticsAsCorrectArray() {
        $stats = $this->getDriver()->getStats();

        $this->assertArrayHasKey('hits', $stats);
        $this->assertArrayHasKey('misses', $stats);
        $this->assertArrayHasKey('count', $stats);
    }

    public function testDidStoreKeyWithoutError() {
        $this->getDriver()->set(SELF::TEST_KEY, SELF::TEST_VALUE);
    }

    public function testReturnsStoredKeyCorrectly() {
        $returnedValue = $this->getDriver()->get(SELF::TEST_KEY);

        $this->assertTrue($returnedValue instanceof CacheItemInterface);
        $this->assertEquals(SELF::TEST_VALUE, $returnedValue->getValue());
    }

    public function testReturnsTheDefaultValueWhenMiss() {
        $item = $this->getDriver()->get("NOT_EXIST_DRIVER", "DEFAULT_VALUE");

        $this->assertTrue($item->isMiss());
        $this->assertEquals("DEFAULT_VALUE", $item->getValue());
    }

    public function testExistReturnsTheCorrectValue() {
        $resultWithSoredKey = $this->getDriver()->exist(SELF::TEST_KEY);
        $resultWithNotExistKey = $this->getDriver()->exist("NOT_EXIST_KEY");

        $this->assertTrue($resultWithSoredKey);
        $this->assertFalse($resultWithNotExistKey);
    }

}
