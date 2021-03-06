<?php namespace buildr\Shell\Runner;

use buildr\Shell\Runner\RunnerInterface;
use buildr\Shell\Runner\ReturnValueOutputInterface;
use buildr\Shell\CommandInterface;

/**
 * Passthru runner
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
class PassthruRunner implements RunnerInterface, ReturnValueOutputInterface {

    private $returnValue;

    /**
     * Run the command
     *
     * @param \buildr\Shell\CommandInterface $command
     *
     * @return \buildr\Shell\Runner\PassthruRunner
     */
    public function run(CommandInterface $command) {
        passthru((string) $command, $this->returnValue);

        return $this;
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
