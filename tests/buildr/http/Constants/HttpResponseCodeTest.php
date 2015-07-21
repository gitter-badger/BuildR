<?php namespace buildr\tests\http\Constants; 

use buildr\Http\Constants\HttpResponseCode;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * HttpResponseCode test case
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Http\Constants
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class HttpResponseCodeTest extends BuildRTestCase {

    public function testItReturnsTheMessageCorrectly() {
        $message = HttpResponseCode::HTTP_FOUND()->getMessage();

        $this->assertEquals('Found', $message);
    }

}
