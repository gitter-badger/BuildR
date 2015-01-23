<?php namespace buildr\Registry;
use buildr\Utils\String\StringUtils;
use buildr\Registry\Exception\ProtectedVariableException;

/**
 * BuildR - PHP based continuous integration server
 *
 * Basic object holder implementation
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Registry
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Registry {

    /**
     * @type string[]
     */
    private static $variables = [];

    /**
     * @type \stdClass[]
     */
    private static $classes = [];

    /**
     * Register a constructed object to registry
     *
     * @param string $bindingName
     * @param \stdClass $concreteClass
     */
    public static final function bindClass($bindingName, $concreteClass) {
        self::$classes[$bindingName] = $concreteClass;
    }

    /**
     * Get a registered object from the registry
     *
     * @param string $bindingName
     * @return \stdClass
     * @throws \InvalidArgumentException
     */
    public static final function getClass($bindingName) {
        if(isset(self::$classes[$bindingName])) {
            return self::$classes[$bindingName];
        }

        throw new \InvalidArgumentException("The registry not has the following binding: {$bindingName}!");
    }

    /**
     * Register a new variable to registry
     *
     * @param string $variableName
     * @param mixed $value
     * @throws \buildr\Registry\Exception\ProtectedVariableException
     */
    public static final function setVariable($variableName, $value) {
        //Check for protected namespace. The variable names is usually sets via dot notated string. If this
        //ends with .protected we allow to set in first time, but not allow to modify after first set
        if(StringUtils::endWith($variableName, '.protected')) {
            if(isset(self::$variables[$variableName])) {
                throw new ProtectedVariableException("The variable {$variableName} is already set, and its protected!");
            }
        }

        self::$variables[$variableName] = $value;
    }

    /**
     * Get a registered variable from registry
     *
     * @param string $variableName
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public static final function getVariable($variableName) {
        if(!isset(self::$variables[$variableName])) {
            throw new \InvalidArgumentException("Undefined variable {$variableName}!");
        }

        return self::$variables[$variableName];
    }

}