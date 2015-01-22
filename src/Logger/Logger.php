<?php namespace buildr\Logger;

/**
 * BuildR - PHP based continuous integration server
 *
 * PSR-3 compatible logger class
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Logger
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Logger {

    public function log($message) {
        var_dump("Log my message: " . $message);
    }

}