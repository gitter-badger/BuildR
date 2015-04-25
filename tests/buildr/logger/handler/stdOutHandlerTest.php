<?php namespace buildr\tests\logger\handler; 

use buildr\Logger\Entry\LogEntry;
use buildr\Logger\Formatter\LineFormatter;
use buildr\Logger\Handler\StdOutHandler;
use buildr\Logger\LogFilterType;
use buildr\tests\Buildr_TestCase as BuildRTestCase;
use Psr\Log\LogLevel;

/**
 * 
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class stdOutHandlerTest extends BuildRTestCase {

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

    public function testItDropsTheEntryIfTheFilterDoesNotMatch() {
        $this->handler->setFilter(LogLevel::CRITICAL, LogFilterType::FILTER_SAME());
        $this->assertFalse($this->handler->handle($this->entry));
    }

    public function testItWorksCorrectlyWhenItsHandlingTheEntry() {
        $this->handler->setFilter(LogLevel::ERROR, LogFilterType::FILTER_SAME());

        $result = $this->handler->handle($this->entry);
        $this->expectOutputRegex('[\[ERROR\] Hello world!]');

        $this->assertTrue($this->entry->isHandled());
        $this->assertTrue($result);
    }



}
