<?php namespace buildr\Shell\Runner;

use buildr\Shell\CommandInterface;

/**
 * Runner using shell_exec()
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
class ShellExecRunner implements RunnerInterface, ExecutionOutputInterface {

    private $output;

    /**
     * Run the command
     *
     * @param \buildr\Shell\CommandInterface $command
     *
     * @return \buildr\Shell\Runner\ShellExecRunner
     */
    public function run(CommandInterface $command) {
        $this->output = shell_exec((string) $command);

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

}
