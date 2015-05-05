<?php namespace buildr\tests\shell\runner;

use buildr\Shell\Runner\ExecRunner;
use buildr\Utils\StringUtils;

/**
 * exec() command runner tests
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Shell\Runner
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class execRunnerTest extends abstractRunnerTester {

    /**
     * @requires OS WIN
     */
    public function testItReturnsTheOutputCorrectlyWin() {
        $runner = new ExecRunner();

        $runner->run($this->getCommandWin());

        $this->assertArrayHasKey(0, $runner->getOutput());
        $this->assertTrue(is_int($runner->getReturnValue()));
        $this->assertTrue(StringUtils::contains($runner->getOutput()[0], 'ECHO'));
    }

    /**
     * @requires OS Linux|nix
     */
    public function testItReturnsTheOutputCorrectlyNix() {
        $runner = new ExecRunner();

        $runner->run($this->getCommandNix());

        $this->assertTrue(is_int($runner->getReturnValue()));
        $this->assertArrayHasKey(0, $runner->getOutput());
    }


}
