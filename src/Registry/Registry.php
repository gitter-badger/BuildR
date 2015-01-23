<?php namespace buildr\Registry;

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
     */
    public static final function setVariable($variableName, $value) {
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