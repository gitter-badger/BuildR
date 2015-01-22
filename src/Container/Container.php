<?php namespace buildr\Container;

class Container {

    private $variables = [];

    private $classes = [];

    public function bindClass($className, $concrete) {

    }

    public function getClass($className) {
        
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