<?php namespace buildr\Loader;

/**
 * BuildR - PHP based continuous integration server
 *
 * Class loader implementation with multiple type of loader support (PSR-4, ClassMap)
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Loader
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class classLoader {

    /**
     * @var \buildr\Loader\classLoaderInterface[]
     */
    private $loaders = [];

    /**
     * Properly include all files require for autoloading support
     */
    public static function loadAutoLoader() {
        //Include interface first All class depends on it
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'classLoaderInterface.php';

        $files = scandir(__DIR__, SCANDIR_SORT_DESCENDING);
        $unnedFiles = ['.', '..', 'classLoader.php', 'classLoaderInterface.php'];

        foreach($files as $k => $file) {
            if(in_array($file, $unnedFiles)) {
                continue;
            }

            require_once __DIR__ . DIRECTORY_SEPARATOR . $file;
        }
    }

    /**
     * Register a new, constructed class loader, and sort by priority. Each class loader have a priority
     * If tow class loader has a same priority the first will be registered and the second priority shifted
     * until a free priority space available. If this occurs this trigger an E_USER_NOTICE
     *
     * On register, this function class the loader register() method. It will allows to listen to loader registration
     *
     *
     * @param \buildr\Loader\classLoaderInterface $classLoader
     * @return bool
     */
    public function registerLoader(classLoaderInterface $classLoader) {
        $priority = $classLoader->getPriority();

        if(!isset($this->loaders[$priority])) {
            $this->loaders[$priority] = $classLoader;
            $classLoader->register();
            return TRUE;
        }

        $classLoader->setPriority($priority+1);
        $this->registerLoader($classLoader);

        trigger_error("Another class Loader is registered with priority {$priority}! Increasing priority by one, to find a new spot.", E_USER_NOTICE);
    }

    /**
     * Return all currently registered laoder class
     *
     * @return \buildr\Loader\classLoaderInterface[]
     */
    public function getLoaders() {
        return $this->loaders;
    }

    /**
     * Return a specific loader at the given priority
     *
     * @param int $priority
     * @return \buildr\Loader\classLoaderInterface
     * @throws \InvalidArgumentException
     */
    public function getLoaderPriority($priority) {
        if(isset($this->loaders[$priority])) {
            return $this->loaders[$priority];
        }

        throw new \InvalidArgumentException("Not found any class Loader for priority {$index}!");
    }

    /**
     * Return a loader class with a specified name
     * This name is hard-coded on all loader class
     *
     * @param string $loaderName
     * @return classLoaderInterface
     * @throws \InvalidArgumentException
     */
    public function getLoaderByName($loaderName) {
        foreach($this->loaders as $loader) {
            if($loader->getName() == $loaderName) {
                return $loader;
            }
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
        foreach($this->loaders as $loader) {
            if($loader->load($className) === TRUE) {
                break;
            }
        }
    }

    /**
     * Main initialization method, it just simply register this class for autoloading
     * with spl_autoload_register() method.
     */
    public function initialize() {
        spl_autoload_register(__NAMESPACE__ . '\classLoader::loadClass');
    }
}