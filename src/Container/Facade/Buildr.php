<?php namespace buildr\Container\Facade;

use buildr\Facade\Facade;

/**
 * DI container facade
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Container\Facade
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @codeCoverageIgnore
 */
class Buildr extends Facade {

    public function getBindingName() {
        return 'buildr';
    }

}
