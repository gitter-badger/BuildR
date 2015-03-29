<?php namespace buildr\tests\logger\attachment;
use buildr\Logger\Attachment\MemoryUsageAttachment;

/**
 * BuildR - PHP based continuous integration server
 *
 * Memory usage attachment tester
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Logger\Attachment
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class MemoryAttachmentTest extends AbstractAttachmentTester {

    protected function setUp() {
        $this->attachment = new MemoryUsageAttachment();

        parent::setUp();
    }

}
