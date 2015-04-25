<?php namespace buildr\Logger\Facade;

use buildr\Facade\Facade;

/**
 * Facade for logger class
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Logger\Facade
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @codeCoverageIgnore
 */
class Logger extends Facade {

    public function getBindingName() {
        return "logger";
    }

}
