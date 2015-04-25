<?php namespace buildr\tests\logger;

use buildr\Logger\Entry\LogEntry;
use buildr\Logger\Formatter\LineFormatter;
use buildr\Logger\Handler\StdOutHandler;
use buildr\Logger\LogFilterType;
use buildr\tests\Buildr_TestCase as BuildRTestCase;
use Psr\Log\LogLevel;

/**
 * Log level filter test
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Logger
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class logFilterTest extends BuildRTestCase {

    /**
     * @type \buildr\Logger\Entry\LogEntryInterface
     */
    private $entry;

    /**
     * @type \buildr\Logger\Handler\StdOutHandler
     */
    private $handler;

    public function setUp() {
        $this->entry = new LogEntry("Hello {replace}!", ['replace' => 'world'], LogLevel::ERROR, new \DateTime());
        $this->handler = new StdOutHandler();
        $this->handler->setFormatter(new LineFormatter());
    }

    public function testLogFilterAboveWorksCorrectly() {
        $this->handler->setFilter(LogLevel::NOTICE, LogFilterType::FILTER_ABOVE());

        $this->assertCount(6, $this->handler->getHandledLevels());
    }

    public function testLogFilterBelowWorksCorrectly() {
        $this->handler->setFilter(LogLevel::NOTICE, LogFilterType::FILTER_BELOW());

        $this->assertCount(2, $this->handler->getHandledLevels());
    }

    public function testLogFilterSameWorksCorrectly() {
        $this->handler->setFilter(LogLevel::NOTICE, LogFilterType::FILTER_SAME());

        $this->assertCount(1, $this->handler->getHandledLevels());
    }

    public function testRemoveFilterWoksCorrectly() {
        $this->handler->setFilter(LogLevel::NOTICE, LogFilterType::FILTER_BELOW());
        $this->handler->removeFilter();

        $this->assertNull($this->handler->getHandledLevels());
    }

    public function testLevelHandlingWithNullFilter() {
        $this->assertTrue($this->handler->isHandleThisLevel(LogLevel::NOTICE));
    }

    public function testLevelHandlingWithActiveFilters() {
        $this->handler->setFilter(LogLevel::NOTICE, LogFilterType::FILTER_SAME());

        $this->assertTrue($this->handler->isHandleThisLevel(LogLevel::NOTICE));
        $this->assertFalse($this->handler->isHandleThisLevel(LogLevel::INFO));
    }


}
