<?php namespace buildr\tests\http\Response\ContentType\Encoder;

use buildr\Http\Response\ContentType\Encoder\JsonContentEncoder;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Abstract class for Response content types test
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Http\Response\ContentType
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class JsonEncoderTest extends BuildRTestCase {

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage JSON responses can't take resource types!
     */
    public function testItThrowExceptionWhenUsingResourceAsInput() {
        $encoder = new JsonContentEncoder();
        $resource = fopen('php://input', 'a+');

        $encoder->encode($resource);
    }

    public function testEncodingWorks() {
        $encoder = new JsonContentEncoder();

        $input = ['Hello' => ['key' => 'world']];
        $this->assertJson($encoder->encode($input));
    }

}
