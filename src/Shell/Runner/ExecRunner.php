<?php namespace buildr\Shell\Runner;

use buildr\Shell\CommandInterface;

/**
 * Shell command runner using exec()
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Shell\Runner
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ExecRunner implements RunnerInterface, ExecutionOutputInterface, ReturnValueOutputInterface {

    /**
     * @type mixed
     */
    private $output;

    /**
     * @type mixed
     */
    private $returnValue;

    /**
     * Run the command
     *
     * @param \buildr\Shell\CommandInterface $command
     *
     * @return \buildr\Shell\Runner\ExecRunner
     */
    public function run(CommandInterface $command) {
        exec((string) $command, $this->output, $this->returnValue);

        return $this;
    }

    /**
     * Return the command output
     *
     * @return mixed
     */
    public function getOutput() {
        return $this->output;
    }

    /**
     * Get the command output
     *
     * @return mixed
     */
    public function getReturnValue() {
        return $this->returnValue;
    }

}
