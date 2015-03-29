<?php namespace buildr\tests\logger\formatter;

use buildr\Logger\Formatter\LineFormatter;
use buildr\Logger\Entry\LogEntry;
use Psr\Log\LogLevel;
use \buildr\tests\logger\formatter\AbstractFormatterTester;

/**
 * BuildR - PHP based continuous integration server
 *
 * Line formatter tester
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Logger\Formatter
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class LineFormatterTest extends AbstractFormatterTester {

    protected function setUp() {
        $this->formatter = new LineFormatter();

        $date = new \DateTime();
        $attachments = ["testAttachmentKey" => "testAttachmentValue"];
        $this->entry = new LogEntry("My {value} message", ["value" => "test"], LogLevel::ERROR, $date, $attachments);

        parent::setUp();
    }

    function testItFormatCorrectly() {
        $result = $this->formatter->format($this->entry);
        $this->assertTrue(is_string($result));
    }


}
