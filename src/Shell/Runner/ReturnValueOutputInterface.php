<?php namespace buildr\Shell\Runner;

/**
 * Common interface for executors the provide command return values
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
interface ReturnValueOutputInterface {

    /**
     * Get the command output
     *
     * @return mixed
     */
    public function getReturnValue();

}
