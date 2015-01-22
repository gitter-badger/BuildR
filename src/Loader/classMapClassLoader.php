<?php namespace buildr\Loader;

class classMapClassLoader implements classLoaderInterface {

    private $priority = 2;

    public function register() {

    }

    public function load($className) {

    }

    public function getName() {
        return "classMapClassLoader";
    }

    public function getPriority() {
        return $this->priority;
    }

    public function setPriority($priority) {
        if(!is_int($priority)) {
            throw new \InvalidArgumentException();
        }

        $this->priority = $priority;
    }
}