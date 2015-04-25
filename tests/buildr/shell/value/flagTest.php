<?php namespace buildr\tests\shell\value; 

use buildr\Shell\Value\Flag;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Flag tests
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
class flagTest extends BuildRTestCase {

    public function testItWorksWithValuePresent() {
        $flag = new Flag('u', 'user');

        $this->assertEquals('-u ' . escapeshellarg('user'), (string) $flag);
    }

    public function testItWorksWithQuotedValuePresent() {
        $flag = new Flag('u', 'qu\\ot\'ed va`lue');

        $this->assertEquals('-u ' . escapeshellarg('qu\\ot\'ed va`lue'), (string) $flag);
    }

    public function testItWorksWithNoValuePresent() {
        $flag = new Flag('h');

        $this->assertEquals('-h', (string) $flag);
    }

}
