<?php namespace buildr\tests\logger\formatter;

use buildr\Logger\Formatter\FormatterInterface;
use buildr\tests\Buildr_TestCase as BuilderTestCase;

/**
 * Abstract class for log formatter classess
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Logger\Formatter
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
abstract class AbstractFormatterTester extends BuilderTestCase {

    /**
     * @type \buildr\Logger\Formatter\FormatterInterface
     */
    protected $formatter;

    /**
     * @type \buildr\Logger\Entry\LogEntryInterface
     */
    protected $entry;

    abstract function testItFormatCorrectly();

    public function testItImplementsInterface() {
        $this->assertTrue($this->formatter instanceof FormatterInterface);
    }

}