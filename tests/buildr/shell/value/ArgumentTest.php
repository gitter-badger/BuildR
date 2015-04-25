<?php namespace buildr\tests\shell\value; 

use buildr\Shell\Value\Argument;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Argument tests
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
class ArgumentTest extends BuildRTestCase {

    public function testItWorksWithValuePresent() {
        $argument = new Argument('arg', 'value');

        $this->assertEquals('--arg ' . escapeshellarg('value'), (string) $argument);
    }

    public function testItWorksWithQuotedValuePresent() {
        $argument = new Argument('arg', 'test\\`er quot\'ed value');

        $this->assertEquals('--arg ' . escapeshellarg('test\\`er quot\'ed value'), (string) $argument);
    }

    public function testItWorksWithNoValuePresent() {
        $argument = new Argument('help');

        $this->assertEquals('--help', (string) $argument);
    }

}
