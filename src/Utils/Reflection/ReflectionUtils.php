<?php namespace buildr\Utils\Reflection;

use \ReflectionClass;
use \ReflectionMethod;

/**
 * BuildR - PHP based continuous integration server
 *
 * Reflection utilities
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Utils\Reflection
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ReflectionUtils {

    /**
     * Returns a dynamically created closure from a class method
     *
     * @param string $className Must be FQN
     * @param string $methodName
     * @param array $constructorParams
     * @return callable
     */
    public static final function getClosureForMethod($className, $methodName, $constructorParams = []) {
        $classReflector = new ReflectionClass($className);
        $methodReflector = $classReflector->getMethod($methodName);
        $methodReflector->setAccessible(TRUE);

        return $methodReflector->getClosure($classReflector->newInstanceArgs($constructorParams));
    }

}