<?php namespace buildr\Loader;

use buildr\Loader\ClassLoaderInterface;

/**
 * Class loader implementation with multiple type of loader support (PSR-4, ClassMap)
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
class ClassLoader {

    /**
     * @var \buildr\Loader\ClassLoaderInterface[]
     */
    private $loaders = [];

    /**
     * Properly include all files require for autoloading support
     *
     * @codeCoverageIgnore
     */
    public static function loadAutoLoader() {
        //Include interface first All class depends on it
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassLoaderInterface.php';
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'ClassMapClassLoader.php';
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'PSR4ClassLoader.php';
    }

    /**
     * Register a new, constructed class loader, and sort by priority. Each class loader have a priority
     * If tow class loader has a same priority the first will be registered and the second priority shifted
     * until a free priority space available. If this occurs this trigger an E_USER_NOTICE
     *
     * On register, this function class the loader register() method. It will allows to listen to loader registration
     *
     * @param \buildr\Loader\ClassLoaderInterface $classLoader
     *
     * @return bool
     */
    public function registerLoader(ClassLoaderInterface $classLoader) {
        $priority = $classLoader->getPriority();

        if(!isset($this->loaders[$priority])) {
            $this->loaders[$priority] = $classLoader;
            $classLoader->register();

            return TRUE;
        }

        $classLoader->setPriority($priority + 1);
        $this->registerLoader($classLoader);

        $errorMessage = "Another class Loader is registered with priority {$priority}! ";
        $errorMessage .= "Increasing priority by one, to find a new spot.";
        trigger_error($errorMessage, E_USER_NOTICE);
    }

    /**
     * Return all currently registered laoder class
     *
     * @return \buildr\Loader\ClassLoaderInterface[]
     */
    public function getLoaders() {
        return $this->loaders;
    }

    /**
     * Return a specific loader at the given priority
     *
     * @param int $priority
     *
     * @return \buildr\Loader\ClassLoaderInterface
     * @throws \InvalidArgumentException
     */
    public function getLoaderPriority($priority) {
        if(isset($this->loaders[$priority])) {
            return $this->loaders[$priority];
        }

        throw new \InvalidArgumentException("Not found any class Loader for priority {$priority}!");
    }

    /**
     * Return a loader class with a specified name
     * This name is hard-coded on all loader class
     *
     * @param string $loaderName
     *
     * @return \buildr\Loader\ClassLoaderInterface[]
     * @throws \InvalidArgumentException
     */
    public function getLoaderByName($loaderName) {
        $loaders = [];

        foreach ($this->loaders as $loader) {
            if($loader->getName() == $loaderName) {
                $loaders[] = $loader;
            }
        }

        if(count($loaders) > 0) {
            return $loaders;
        }

        throw new \InvalidArgumentException("Not found any class Loader, tagged with \"{$loaderName}\" name!");
    }

    /**
     * Main method to load a class to the system. Its basically scan all registered loader
     * and try to load the given class. The first valid loader will be used
     *
     * @param int $className
     */
    public function loadClass($className) {
        //Sorted by priority on register
        foreach ($this->loaders as $loader) {
            if($loader->load($className) === TRUE) {
                break;
            }
        }
    }

    /**
     * Main initialization method, it just simply register this class for autoloading
     * with spl_autoload_register() method.
     *
     * @codeCoverageIgnore
     */
    public function initialize() {
        spl_autoload_register(__NAMESPACE__ . '\ClassLoader::loadClass');
    }

}
