<?php namespace buildr\Container\Repository; 

/**
 * Interface for various service repositories
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
interface ServiceRepositoryInterface {

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
     * @return TRUE
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
