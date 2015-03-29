<?php namespace buildr\tests\logger\attachment;

use buildr\Logger\Attachment\AttachmentInterface;
use buildr\tests\Buildr_TestCase as BuilderTestCase;

/**
 * BuildR - PHP based continuous integration server
 *
 * Abstract Logger attachment test
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Logger\Attachment
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class AbstractAttachmentTester extends BuilderTestCase {

    /**
     * @type \buildr\Logger\Attachment\AttachmentInterface
     */
    protected $attachment;

    public function testItImplementsInterface() {
        $this->assertTrue($this->attachment instanceof AttachmentInterface);
    }

    public function testItReturnsTheIdentifierAsString() {
        $this->assertTrue(is_string($this->attachment->getIdentifier()));
    }

    public function testItValueNotNull() {
        $this->assertNotNull($this->attachment->getValue());
    }

}
