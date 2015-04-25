<?php namespace buildr\tests\shell\value; 

use buildr\Shell\Value\Parameter;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Parameter tests
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Shell\Value
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class parameterTest extends BuildRTestCase {

    public function testItReturnsTheValueProperly() {
        $parameter = new Parameter('Quot\'ed "example\\long" s`tring');

        $this->assertEquals(escapeshellarg('Quot\'ed "example\\long" s`tring'), (string) $parameter);
    }

}
