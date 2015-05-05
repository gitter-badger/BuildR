<?php namespace buildr\tests\shell\runner;

use buildr\Shell\Runner\ShellExecRunner;
use buildr\Utils\StringUtils;

/**
 * shell_exec() runner test
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
class shellExecRunnerTest extends abstractRunnerTester {

    /**
     * @requires OS WIN
     */
    public function testItReturnsTheOutputCorrectlyWin() {
        $runner = new ShellExecRunner();

        $runner->run($this->getCommandWin());

        $this->assertTrue((strlen($runner->getOutput()) > 0));
        $this->assertTrue(StringUtils::contains($runner->getOutput(), 'ECHO'));
    }

    /**
     * @requires OS Linux|nix
     */
    public function testItReturnsTheOutputCorrectlyNix() {
        $runner = new ShellExecRunner();

        $runner->run($this->getCommandNix());

        $this->assertTrue((strlen($runner->getOutput()) > 0));
    }

}
