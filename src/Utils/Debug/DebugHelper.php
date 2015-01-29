<?php
/**
 * BuildR - PHP based continuous integration server
 *
 * Debug helper for debug purposes only.
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
 * @param mixed $var
 */
function d($var) {
    var_dump($var);
}

/**
 * Var-dumps the given variable and stop the program execution
 *
 * @param mixed $var
 */
function dd($var) {
    die(var_dump($var));
}
