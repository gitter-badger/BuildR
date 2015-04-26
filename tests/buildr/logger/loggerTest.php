<?php namespace buildr\tests\logger; 

use buildr\Logger\Attachment\MemoryUsageAttachment;
use buildr\Logger\Formatter\LineFormatter;
use buildr\Logger\Handler\StdOutHandler;
use buildr\Logger\Logger;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;
use Psr\Log\LogLevel;

/**
 * Logger test case
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
class loggerTest extends BuildRTestCase {

    /**
     * @type \buildr\Logger\Logger
     */
    private $logger;

    public function setUp() {
        $this->logger = new Logger('testLogger');
    }

    /**
     * @expectedException \buildr\Logger\Exception\InvalidTimeZoneException
     * @expectedExceptionMessage This TimeZone string (notExistTimeZone) is no a valid time zone!
     */
    public function testItThrowsExceptionWhenConstructedWithInvalidTimezoneString() {
        $logger = new Logger('testLogger2', 'notExistTimeZone');
    }

    public function testItReturnsTheNameCorrectly() {
        $this->assertEquals('testLogger', $this->logger->getName());
    }

    public function testItStoreHandlersCorrectly() {
        $handlerOne = new StdOutHandler();
        $handlerTwo = new StdOutHandler();

        $this->logger->pushHandler($handlerOne);
        $this->logger->pushHandler($handlerTwo);

        $handlersInStack = $this->getPrivatePropertyFromClass(get_class($this->logger), 'handlers', $this->logger);

        $this->assertCount(2, $handlersInStack);
    }

    public function testItStoresAttachmentsCorrectly() {
        $attachmentOne = new MemoryUsageAttachment();
        $attachmentTwo = new MemoryUsageAttachment();

        $this->logger->pushAttachment($attachmentOne);
        $this->logger->pushAttachment($attachmentTwo);

        $attachmentsStack = $this->getPrivatePropertyFromClass(get_class($this->logger), 'attachments', $this->logger);

        $this->assertCount(2, $attachmentsStack);
    }

    public function testLogWorksCorrectly() {
        $attachment = new MemoryUsageAttachment();
        $handler = new StdOutHandler();
        $handler->setFormatter(new LineFormatter());

        $this->logger->pushAttachment($attachment);
        $this->logger->pushHandler($handler);

        $this->logger->log(LogLevel::INFO, 'Hello {str}!', ['str' => 'world']);
        $this->expectOutputRegex('[\S]');
    }
}
