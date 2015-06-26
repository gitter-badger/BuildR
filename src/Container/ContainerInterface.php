<?php namespace buildr\Container; 

/**
 * Interface for Dependency injection container
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage 
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface ContainerInterface {

    /**
     * Get the specified service out of the container
     *
     * @param string $serviceId
     *
     * @return mixed
     * @throws \buildr\Container\Exception\UndefinedBindingException
     */
    public function get($serviceId);

    /**
     * Add a new service (concrete class) to the container
     *
     * @param string $serviceId
     * @param object $service
     *
     * @return bool
     * @throws \buildr\Container\Exception\ServiceAlreadyRegisteredException
     */
    public function add($serviceId, $service);

    /**
     * Determines that the given service id is
     * set in the container
     *
     * @param string $serviceId
     *
     * @return bool
     */
    public function has($serviceId);

    /**
     * Remove the given service from repository
     *
     * @param string $serviceId
     *
     * @return bool
     * @throws \buildr\Container\Exception\UndefinedBindingException
     */
    public function remove($serviceId);

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
    public function bind($abstract, $concrete, $shared = FALSE);

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
     */
    public function construct($service, $shared = FALSE);

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
    public function singleton($concrete);

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
    public function setProperty($propertyName, $propertyValue, $isProtected = FALSE);

    /**
     * Get a property from container
     *
     * @param string $propertyName
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function getProperty($propertyName, $defaultValue = NULL);

}
