<?php namespace buildr\tests\shell\runner; 

use buildr\Shell\Command;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Abstract class for comamnd runners
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
class abstractRunnerTester extends BuildRTestCase {

    /**
     * Get a command string to test runner with windows system
     *
     * @return \buildr\Shell\CommandInterface
     */
    public function getCommandWin() {
        $command = new Command('echo');

        return $command;
    }

    /**
     * Get a command string to test runner with *nix system
     *
     * @return \buildr\Shell\CommandInterface
     */
    public function getCommandNix() {
        $command = new Command('uname');

        return $command;
    }

}
