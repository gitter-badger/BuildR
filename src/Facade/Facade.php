<?php namespace buildr\Facade;

use buildr\Registry\Registry;

/**
 * Abstract class for facades
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Facade
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @codeCoverageIgnore
 */
abstract class Facade {

    abstract public function getBindingName();

    public static function __callStatic($method, $arguments) {
        $reflector = new \ReflectionClass(static::class);

        $bindingName = $reflector->getMethod('getBindingName')->invoke($reflector->newInstanceWithoutConstructor());

        $class = Registry::getClass($bindingName);

        return call_user_func_array([
            $class,
            $method
        ], $arguments);
    }

}
