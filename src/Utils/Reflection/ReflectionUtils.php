<?php namespace buildr\Utils\Reflection;

use buildr\Utils\Reflection\Annotation\Reader;
use ReflectionClass;

/**
 * Reflection utilities
 *
 * BuildR PHP Framework
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
     *
     * @return callable
     */
    public static final function getClosureForMethod($className, $methodName, $constructorParams = []) {
        $classReflector = new ReflectionClass($className);
        $methodReflector = $classReflector->getMethod($methodName);
        $methodReflector->setAccessible(TRUE);

        return $methodReflector->getClosure($classReflector->newInstanceArgs($constructorParams));
    }

    /**
     * Return the annotation reader for a given class, or the class method
     *
     * @param string $className
     * @param null|string $methodName
     *
     * @return \buildr\Utils\Reflection\Annotation\Reader
     */
    public static final function getAnnotationReader($className, $methodName = NULL) {
        $classReflector = new ReflectionClass($className);

        if($methodName !== NULL) {
            $methodReflector = $classReflector->getMethod($methodName);
            $methodReflector->setAccessible(TRUE);
            $docBlock = $methodReflector->getDocComment();

            return new Reader($docBlock);
        }

        return new Reader($docBlock = $classReflector->getDocComment());
    }
}
