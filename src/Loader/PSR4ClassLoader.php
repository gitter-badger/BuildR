<?php namespace buildr\Loader;

/**
 * PSR-4 compatible class loader implementation
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Loader
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class PSR4ClassLoader implements classLoaderInterface {

    const NAME = "PSR4ClassLoader";

    /**
     * Priority holder
     *
     * @type int
     */
    private $priority = 1;

    /**
     * Holds all currently registered namespace and base location
     *
     * @type array
     */
    private $registeredNamespaces = [];

    /**
     * Called on loader registration. Its allow to listen to registration event
     *
     * @return void
     * @codeCoverageIgnore
     */
    public function register() {
        ;
    }

    /**
     * Load the specified class
     *
     * @param string $className
     *
     * @return bool
     */
    public function load($className) {
        foreach ($this->registeredNamespaces as $singleNamespace) {
            $prefix = $singleNamespace[0];
            $basePath = $singleNamespace[1];

            $prefixLength = strlen($prefix);
            if(strncmp($prefix, $className, $prefixLength) !== 0) {
                continue;
            }

            $relativeClassName = substr($className, $prefixLength);
            $fileLocation = $basePath . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClassName) . '.php';

            if(file_exists($fileLocation)) {
                include_once $fileLocation;

                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Return the priority of this loader. It's not a constant!
     *
     * @return int
     */
    public function getPriority() {
        return $this->priority;
    }

    /**
     * Set the priority of this autolaoder. Its called on registration when the pre-specified priority
     * is already reserved by another loader
     *
     * @param int $priority
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function setPriority($priority) {
        if(!is_int($priority)) {
            throw new \InvalidArgumentException("The specified value is not an integer!");
        }

        $this->priority = $priority;
    }

    /**
     * The loader unique name
     *
     * @return \buildr\Loader\classLoaderInterface
     */
    public function getName() {
        return self::NAME;
    }

    /**
     * Namespace registration
     *
     * @param string $namespace
     * @param string $basePath
     */
    public function registerNamespace($namespace, $basePath) {
        $this->registeredNamespaces[] = [
            $namespace,
            $basePath
        ];
    }

}
