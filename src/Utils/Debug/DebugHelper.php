<?php
/**
 * Debug helper for debug purposes only.
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */

/**
 * Var-dumps the given variable
 *
 * @codeCoverageIgnore
 *
 * @param mixed $var
 */
function d($var) {
    var_dump($var);
}

/**
 * Var-dumps the given variable and stop the program execution
 *
 * @codeCoverageIgnore
 *
 * @param mixed $var
 */
function dd($var) {
    die(var_dump($var));
}
