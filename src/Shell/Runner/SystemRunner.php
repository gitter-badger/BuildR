<?php namespace buildr\Shell\Runner;

use buildr\Shell\CommandInterface;

/**
 * Runner using system()
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
class SystemRunner implements RunnerInterface, ReturnValueOutputInterface {

    private $returnValue;

    /**
     * Run the command
     *
     * @param \buildr\Shell\CommandInterface $command
     *
     * @return \buildr\Shell\Runner\SystemRunner
     */
    public function run(CommandInterface $command) {
        system((string) $command, $this->returnValue);

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
