<?php namespace buildr\Container;

use buildr\Container\Exception\AbstractionException;
use buildr\Container\Exception\CircularDependencyException;
use buildr\Container\Exception\InstantiationException;
use buildr\Container\Exception\UndefinedBindingException;
use buildr\Container\Repository\ServiceRepositoryInterface;

/**
 * Dependency injection container implementation
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Container
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Container implements ContainerInterface {

    /**
     * @type \buildr\Container\Repository\ServiceRepositoryInterface
     */
    private $repository;

    /**
     * Store interface bindings
     *
     * @type array
     */
    private $bindings;

    /**
     * @type array
     */
    private $serviceCreating = [];

    /**
     * Constructor
     *
     * @param \buildr\Container\Repository\ServiceRepositoryInterface $repository
     *
     * @codeCoverageIgnore
     */
    public function __construct(ServiceRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    /**
     * Get the specified service out of the container
     *
     * @param string $serviceId
     *
     * @return mixed
     * @throws \buildr\Container\Exception\UndefinedBindingException
     *
     * @codeCoverageIgnore
     */
    public function get($serviceId) {
        return $this->repository->get($serviceId);
    }

    /**
     * Add a new service (concrete class) to the container
     *
     * @param string $serviceId
     * @param object $service
     *
     * @return bool
     * @throws \buildr\Container\Exception\ServiceAlreadyRegisteredException
     *
     * @codeCoverageIgnore
     */
    public function add($serviceId, $service) {
        return $this->repository->add($serviceId, $service);
    }

    /**
     * Determines that the given service id is
     * set in the container
     *
     * @param string $serviceId
     *
     * @return bool
     *
     * @codeCoverageIgnore
     */
    public function has($serviceId) {
        return $this->repository->has($serviceId);
    }

    /**
     * Remove the given service from repository
     *
     * @param string $serviceId
     *
     * @return bool
     * @throws \buildr\Container\Exception\UndefinedBindingException
     *
     * @codeCoverageIgnore
     */
    public function remove($serviceId) {
        return $this->repository->remove($serviceId);
    }

    /**
     * Bind an interface to concrete implementation in container
     * for future resolving
     *
     * @param string $abstract
     * @param string $concrete
     * @param bool $shared Allow to use shared resources?
     *
     * @return bool
     * @throws \buildr\Container\Exception\AbstractionException
     * @throws \ReflectionException
     */
    public function bind($abstract, $concrete, $shared = FALSE) {
        $reflector = new \ReflectionClass($abstract);

        //Check that the provided abstract is abstract
        if(!($reflector->isAbstract()) || !($reflector->isInterface())) {
            throw new AbstractionException("Unable to bind not abstract class!");
        }

        $this->bindings[$abstract] = [$concrete, $shared];

        return TRUE;
    }

    /**
     * Try to resolve a class dependency thought the container and return to class instance
     * If the $shared value is true, the container will user shared resources, that
     * already exist in the repository
     *
     * @param string $service
     * @param bool $shared
     *
     * @return object
     * @throws \ReflectionException
     * @throws \buildr\Container\Exception\UndefinedBindingException
     * @throws \buildr\Container\Exception\AbstractionException
     * @throws \buildr\Container\Exception\InstantiationException
     * @throws \buildr\Container\Exception\CircularDependencyException
     */
    public function construct($service, $shared = FALSE) {
        if(isset($this->serviceCreating[$service])) {
            $message = 'Circular dependency detected: ';
            $message .= implode(' => ', array_keys($this->serviceCreating)) . " => " . (string) $service;
            throw new CircularDependencyException($message);
        }

        $this->serviceCreating[$service] = TRUE;

        $reflector = new \ReflectionClass($service);

        //If the class is an abstract class, cant create a new instance
        if(($reflector->isAbstract()) && ($reflector->getModifiers() & \ReflectionClass::IS_EXPLICIT_ABSTRACT)) {
            throw new AbstractionException("Cant instantiate abstract classes!");
        }

        //If is an interface, try to resolve binded abstract pair from bindings
        if($reflector->isInterface()) {
            if(!isset($this->bindings[$service])) {
                throw new UndefinedBindingException("Cant find binding for interface! (" . $service . ")");
            }

            $binding = $this->bindings[$service];
            $service = $binding[0];
            $shared = $binding[1];

            //We have a binding name (eg. a named service, try to get from the repository first)
            if(($shared === TRUE) && ($this->repository->has($service))) {
                unset($this->serviceCreating[$service]);

                return $this->repository->get($service);
            }

            $reflector = new \ReflectionClass($service);
        }

        //If we allow to use shared service, check that class is exist in service repository
        if(($shared === TRUE) && ($this->repository->has($service))) {
            unset($this->serviceCreating[$service]);

            return $this->repository->get($service);
        }

        $classConstructor = $reflector->getConstructor();

        //This class didn't specify a constructor, so we create a new instance directly
        if($classConstructor === NULL) {
            unset($this->serviceCreating[$service]);

            return new $service;
        }

        try {
            $dependencyParameters = $classConstructor->getParameters();
            $resolvedDependencies = $this->resolveClassDependencies($dependencyParameters, $shared);

            unset($this->serviceCreating[$service]);
            return $reflector->newInstanceArgs($resolvedDependencies);
        } catch(\Exception $e) {
            throw new InstantiationException("Unable to instantiate class (" . $service . ")! " . $e->getMessage());
        }
    }

    /**
     * Try to return a single instance of the class, if is not already
     * in the repository try to instantiate a new object and add the
     * instance to the repository
     *
     * @param string $concrete
     *
     * @return object
     * @throws \buildr\Container\Exception\InstantiationException
     */
    public function singleton($concrete) {
        if($this->repository->has($concrete)) {
            return $this->repository->get($concrete);
        }

        try {
            $resolved = $this->construct($concrete);
            $this->repository->add($concrete, $resolved);

            return $resolved;
        } catch(\Exception $e) {
            throw new InstantiationException($e->getMessage());
        }
    }

    /**
     * Set a property in container
     *
     * @param string $propertyName
     * @param mixed $propertyValue
     * @param bool $isProtected
     *
     * @return void
     * @throw \buildr\Container\Exception\ProtectedPropertyException
     */
    public function setProperty($propertyName, $propertyValue, $isProtected = FALSE) {
        $this->repository->setProperty($propertyName, $propertyValue, $isProtected);
    }

    /**
     * Get a property from container
     *
     * @param string $propertyName
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function getProperty($propertyName, $defaultValue = NULL) {
        return $this->repository->getProperty($propertyName, $defaultValue);
    }
    
    /**
     * Resolve a class dependencies by the constructor parameters
     *
     * @param \ReflectionParameter[] $dependencies
     * @param bool $shared
     *
     * @return array
     * @throws \Exception
     */
    private function resolveClassDependencies($dependencies, $shared) {
        $classDependencies = [];

        foreach($dependencies as $dependency) {
            //Check if the current dependency is binded or not
            $dependencyClass = $dependency->getClass();

            try {
                if($dependencyClass === NULL) {
                    $classDependencies[] = $this->resolveUnBindedDependency($dependency);
                } else {
                    $classDependencies[] = $this->resolveBindedDependency($dependency, $shared);
                }
            } catch(\Exception $e) {
                throw $e;
            }
        }

        return $classDependencies;
    }

    /**
     * Resolve a dependency parameter when is not type-hinted
     *
     * @param \ReflectionParameter $dependency
     *
     * @return object
     * @throws \Exception
     */
    private function resolveUnBindedDependency($dependency) {
        if($dependency->isDefaultValueAvailable()) {
            return $dependency->getDefaultValue();
        } else {
            throw new \Exception("Cant resolve un-binded dependency. No default value available!");
        }
    }

    /**
     * Resolve a class dependency parameter when is type-hinted
     * If the type-hint not instantiable this method return the parameter
     * default value, if it presents
     *
     * @param \ReflectionParameter $dependency
     * @param bool $shared
     *
     * @return object
     * @throws \Exception
     */
    private function resolveBindedDependency($dependency, $shared) {
        try {
            return $this->construct($dependency->getClass()->getName(), $shared);
        } catch(\Exception $e) {
            if($dependency->isDefaultValueAvailable()) {
                return $dependency->getDefaultValue();
            } else {
                throw $e;
            }
        }
    }

}
