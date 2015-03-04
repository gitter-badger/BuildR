<?php namespace buildr\Config\Facade;

use buildr\Facade\Facade;

/**
 * BuildR - PHP based continuous integration server
 *
 * Configuration facade
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Config\Facade
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Config extends Facade {

    public function getBindingName() {
        return 'config';
    }
}
