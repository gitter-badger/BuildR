<?php namespace buildr\tests\cache;

use buildr\Cache\Item\CacheItem;
use buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * CacheItem test
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\CacheItemTest
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class CacheItemTest extends BuildRTestCase {

    /**
     * @type \buildr\Cache\Item\CacheItem
     */
    protected $cacheItem;

    const TEST_VALUE = "TEST_VALUE";

    const TEST_KEY = "TEST_KEY";

    protected function setUp() {
        $this->cacheItem = new CacheItem(self::TEST_KEY, self::TEST_VALUE, TRUE);

        parent::setUp();
    }

    public function testDidReturnsTheKeyCorrectly() {
        $this->assertEquals(self::TEST_KEY, $this->cacheItem->getKey());
    }

    public function testDidReturnsTheValueCorrectly() {
        $this->assertEquals(self::TEST_VALUE, $this->cacheItem->getValue());
    }

    public function testItReturnsTheHitCorrectly() {
        $this->assertTrue($this->cacheItem->isHit());
    }

    public function testItReturnsTheMissCorrectly() {
        $this->assertFalse($this->cacheItem->isMiss());
    }
}
