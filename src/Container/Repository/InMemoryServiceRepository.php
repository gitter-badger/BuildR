<?php namespace buildr\Container\Repository;

use buildr\Container\Exception\ProtectedPropertyException;
use buildr\Container\Exception\UndefinedBindingException;
use buildr\Container\Exception\ServiceAlreadyRegisteredException;

/**
 * In memory service repository
 *
 * A service repository that stores objects in the memory, for the current
 * runtime. If the script is executed the registered services destroyed.
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Container\Repository
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class InMemoryServiceRepository implements ServiceRepositoryInterface {

    /**
     * @type array
     */
    private $storage = [];

    /**
     * @type array
     */
    private $propertyStorage;

    /**
     * Get the specified service out of the container
     *
     * @param string $serviceId
     *
     * @return mixed
     * @throws \buildr\Container\Exception\UndefinedBindingException
     */
    public function get($serviceId) {
        if($this->has($serviceId)) {
            return $this->storage[$serviceId];
        }

        throw new UndefinedBindingException("The Container not has the following binding: " . $serviceId);
    }

    /**
     * Add a new service (concrete class) to the container
     *
     * @param string $serviceId
     * @param object $service
     *
     * @return TRUE
     * @throws \buildr\Container\Exception\ServiceAlreadyRegisteredException
     */
    public function add($serviceId, $service) {
        if($this->has($serviceId)) {
            $message = "The following serviceId (" . $serviceId . ") is already registered!";
            throw new ServiceAlreadyRegisteredException($message);
        }

        $this->storage[$serviceId] = $service;

        return TRUE;
    }

    /**
     * Determines that the given service id is
     * set in the container
     *
     * @param string $serviceId
     *
     * @return bool
     */
    public function has($serviceId) {
        return (isset($this->storage[$serviceId])) ? TRUE : FALSE;
    }

    /**
     * Remove the given service from repository
     *
     * @param string $serviceId
     *
     * @return bool
     * @throws \buildr\Container\Exception\UndefinedBindingException
     */
    public function remove($serviceId) {
        if(!$this->has($serviceId)) {
            throw new UndefinedBindingException("The Container not has the following binding: " . $serviceId);
        }

        unset($this->storage[$serviceId]);

        return TRUE;
    }

    /**
     * Set a property in container
     *
     * @param string $propertyName
     * @param mixed $propertyValue
     * @param bool $isProtected
     *
     * @return void
     * @throws \buildr\Container\Exception\ProtectedPropertyException
     */
    public function setProperty($propertyName, $propertyValue, $isProtected = FALSE) {
        if(isset($this->propertyStorage[$propertyName])
            && $this->propertyStorage[$propertyName]['protected'] === TRUE) {
            $message = "The property (" . $propertyName . ") is already set, and is protected!";
            throw new ProtectedPropertyException($message);
        }

        $element = [];
        $element['value'] = $propertyValue;
        $element['protected'] = (bool) $isProtected;

        $this->propertyStorage[$propertyName] = $element;
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
        if(isset($this->propertyStorage[$propertyName])) {
            return $this->propertyStorage[$propertyName]['value'];
        }

        return $defaultValue;
    }




}
