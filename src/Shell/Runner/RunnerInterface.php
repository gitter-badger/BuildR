<?php namespace buildr\Shell\Runner;

use buildr\Shell\CommandInterface;

/**
 * Runner interface
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
interface RunnerInterface {

    /**
     * Run the command
     *
     * @param \buildr\Shell\CommandInterface $command
     *
     * @return mixed
     */
    public function run(CommandInterface $command);

}
