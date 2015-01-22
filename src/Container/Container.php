<?php namespace buildr\Container;

/**
 * BuildR - PHP based continuous integration server
 *
 * Basic object holder implementation
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Container
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Container {

    private $variables = [];

    private $classes = [];

    /**
     * Singleton object holder
     *
     * @type \buildr\Container\Container
     */
    private static $instance;

    /**
     * Singleton getter
     *
     * @return \buildr\Container\Container
     */
    public static function getInstance() {
        if(self::$instance === NULL) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function bindClass($bindingName, $concreteClass) {
        $this->classes[$bindingName] = $concreteClass;
    }

    public function getClass($bindingName) {
        return $this->classes[$bindingName];
    }

    public function setVariable($variableName, $value) {
        $this->variables[$variableName] = $value;
    }

    public function getVariable($variableName) {
        if(!isset($this->variables[$variableName])) {
            throw new \Exception("Undefined variable!");
        }

        return $this->variables[$variableName];
    }

}