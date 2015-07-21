<?php namespace buildr\tests\http\Header\Writer;

use buildr\Http\Header\Writer\HtmlHeaderWriter;
use buildr\tests\http\Header\Writer\AbstractHeaderWriterTestCase;

/**
 * HTML header writer test case.
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Http\Header\Writer
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class HtmlHeaderWriterTest extends AbstractHeaderWriterTestCase {

    /**
     * @runInSeparateProcess
     */
    public function testIsWriteAllTheHeaders() {
        $writer = new HtmlHeaderWriter();
        $writerResult = $writer->write($this->getDummyHeaderBag());

        $this->assertNull($writerResult);

        if(extension_loaded('xdebug')) {
            $headerList = xdebug_get_headers();

            $this->assertCount(2, $headerList);
            $this->assertEquals($this->getExpectedHeaderList(), $headerList);
        } else {
            $this->markTestIncomplete('The XDebug extension is not found!');
        }
    }

}
