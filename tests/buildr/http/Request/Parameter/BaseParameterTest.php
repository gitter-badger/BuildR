<?php namespace buildr\tests\Htpp\Request\Parameter; 

use buildr\Http\Request\Parameter\BaseHttpParameter;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * BaseHttpParameter test case
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Http\Request\Parameter
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class BaseParameterTest extends BuildRTestCase {

    /**
     * @type \buildr\Http\Request\Parameter\BaseHttpParameter
     */
    private $parameter;

    protected function setUp() {
        $this->parameter = new BaseHttpParameter('Test', '1');

        parent::setUp();
    }

    public function testAllCasters() {
        $this->assertTrue(is_string($this->parameter->asString()));
        $this->assertTrue(is_int($this->parameter->asInt()));
        $this->assertTrue(is_bool($this->parameter->asBool()));
        $this->assertTrue(is_float($this->parameter->asFloat()));
        $this->assertTrue(is_array($this->parameter->asArray()));
        $this->assertTrue(is_string($this->parameter->asRaw()));
        $this->assertTrue(is_string((string) $this->parameter));
    }

    public function testItReturnsTheNameCorrectly() {
        $this->assertEquals('Test', $this->parameter->getName());
    }

}
