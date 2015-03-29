<?php namespace buildr\tests\logger\entry;

use buildr\Logger\Entry\LogEntry;
use buildr\tests\Buildr_TestCase as BuilderTestCase;
use Psr\Log\LogLevel;

/**
 * BuildR - PHP based continuous integration server
 *
 * Log entry test
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Logger\Entry
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class LogEntryTest extends BuilderTestCase {

    /**
     * @type \buildr\Logger\Entry\LogEntryInterface
     */
    private $entry;

    /**
     * @type \buildr\Logger\Entry\LogEntryInterface
     */
    private $entryWithNoAttachment;

    protected function setUp() {
        $date = new \DateTime();
        $attachments = ["testAttachmentKey" => "testAttachmentValue"];
        $this->entry = new LogEntry("My {value} message", ["value" => "test"], LogLevel::ERROR, $date, $attachments);
        $this->entryWithNoAttachment = new LogEntry("My {value} message", ["value" => "test"], LogLevel::ERROR, $date);

        parent::setUp();
    }

    public function testItReturnsLevelAsString() {
        $this->assertTrue(is_string($this->entry->getLevel()));
    }

    public function testItReturnsAttachmentsAsArray() {
        $this->assertTrue(is_array($this->entryWithNoAttachment->getAttachments()));
        $this->assertArrayHasKey('testAttachmentKey', $this->entry->getAttachments());
    }

    public function testItReturnsDateAsProperObjectType() {
        $this->assertTrue($this->entry->getDate() instanceof \DateTime);
    }

    public function testItFormatMessageCorrectly() {
        $this->assertEquals("My test message", $this->entry->getMessage());
        $this->assertEquals("My {value} message", $this->entry->getRawMessage());
    }

    public function testHandlingStateWorksCorrectly() {
        $this->assertFalse($this->entry->isHandled());

        $this->entry->setHandled();

        $this->assertTrue($this->entry->isHandled());
    }


}
