<?php namespace buildr\tests\shell\runner;

use buildr\Shell\Runner\PassthruRunner;

/**
 * passthru() runner tests
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
class passthruRunnerTest extends abstractRunnerTester {

    /**
     * @requires OS WIN
     */
    public function testItWorksCorrectlyOnWin() {
        $runner = new PassthruRunner();

        $this->expectOutputRegex('[\S]');
        $runner->run($this->getCommandWin());

        $this->assertTrue(is_int($runner->getReturnValue()));
    }

    /**
     * @requires OS Linux|nix
     */
    public function testItReturnsTheOutputCorrectlyNix() {
        $runner = new PassthruRunner();

        $this->expectOutputRegex('[\S]');
        $runner->run($this->getCommandNix());

        $this->assertTrue(is_int($runner->getReturnValue()));
    }

}
