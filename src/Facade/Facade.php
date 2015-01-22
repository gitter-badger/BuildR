<?php namespace buildr\Facade;

use buildr\Container\Container;

/**
 * BuildR - PHP based continuous integration server
 *
 * Abstract class for facades
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Facade
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Facade {

    public static function getBindingName() {
        ;
    }

    public static function __callStatic($method, $arguments) {
        $bindingName = static::getBindingName();
        $class = Container::getInstance()->getClass($bindingName);

        call_user_func_array([$class, $method], $arguments);
    }

}