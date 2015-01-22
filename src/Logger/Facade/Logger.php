<?php namespace buildr\Logger\Facade;

use buildr\Facade\Facade;

/**
 * BuildR - PHP based continuous integration server
 *
 * Facade for logger class
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Logger\Facade
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Logger extends Facade {

    public static function getBindingName() {
        return "logger";
    }
}