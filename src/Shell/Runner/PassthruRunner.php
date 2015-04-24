<?php namespace buildr\Shell\Runner;

use buildr\Shell\CommandInterface;

/**
 * BuildR - PHP based continuous integration server
 *
 * Passthru runner
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