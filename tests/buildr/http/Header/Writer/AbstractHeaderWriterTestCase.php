<?php namespace buildr\tests\http\Header\Writer;

use buildr\Http\Header\HeaderBag;
use buildr\Http\Header\ResponseHeaderBag;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Abstract headerWriter test case.
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
class AbstractHeaderWriterTestCase extends BuildRTestCase {

    /**
     * Returns a dummy ResponseHeaderBag object to use since testing.
     *
     * @return \buildr\Http\Header\ResponseHeaderBag
     */
    public function getDummyHeaderBag() {
        $dummyData = [
            HeaderBag::HEADER_PROTOCOL => 'HTTP/1.1',
            HeaderBag::HEADER_STATUS_CODE => 200,
            HeaderBag::HEADER_STATUS_TEXT => 'Ok',
            'Host' => 'http://host.tld',
            'Content-Type' => 'application/json'
        ];

        return new ResponseHeaderBag($dummyData);
    }

    public function getExpectedHeaderList() {
        return [
            'Host: http://host.tld',
            'Content-Type: application/json',
        ];
    }

}
