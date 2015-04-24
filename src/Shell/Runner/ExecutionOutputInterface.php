<?php namespace buildr\Shell\Runner;

/**
 * BuildR - PHP based continuous integration server
 *
 * Common interface for executors the provides command outputs
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Shell\Runner
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface ExecutionOutputInterface {

    /**
     * Return the command output
     *
     * @return mixed
     */
    public function getOutput();

}
