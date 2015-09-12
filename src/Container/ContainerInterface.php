<?php namespace buildr\Container; 

use buildr\ServiceProvider\ServiceProviderInterface;
use Interop\Container\ContainerInterface as InteropContainerInterface;
use \ArrayAccess;

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
interface ContainerInterface extends InteropContainerInterface, ArrayAccess{

    /**
     * Return a new contextual builder to add a new binding
     *
     * @param string $concrete
     *
     * @return \buildr\Container\ContextualBuilder
     */
    public function when($concrete);

    /**
     * Register a new instance to the container
     *
     * @param string $id Service name
     * @param object $value Registered object
     *
     * @return \buildr\Container\ContainerInterface
     * @throws \buildr\Container\Alias\CannotChangeException
     */
    public function instance($id, $value);

    /**
     * Register a new instance to the container as a closure
     *
     * @param string $id Service name
     * @param \Closure $value closure to register
     *
     * @return \buildr\Container\ContainerInterface
     * @throws \buildr\Container\Alias\CannotChangeException
     */
    public function closure($id, \Closure $value);

    /**
     * Bind an interface to its concrete implementation
     *
     * @param string $id ServiceName
     * @param string $class The binded class name
     *
     * @return \buildr\Container\ContainerInterface
     * @throws \buildr\Container\Alias\CannotChangeException
     */
    public function bind($id, $class);

    /**
     * Register a new alias for a class
     *
     * @param string $name The alias name
     * @param string $origin The original service name
     *
     * @return \buildr\Container\ContainerInterface
     */
    public function alias($name, $origin);

    /**
     * Register a class that can be used in autowireing
     *
     * @param string $id Service name
     * @param null|object $class
     *
     * @return \buildr\Container\ContainerInterface
     */
    public function wire($id, $class = NULL);

    /**
     * Freeze a service in the container, so that cant be changed or removed
     *
     * @param string $id Service or alias name
     *
     * @return \buildr\Container\ContainerInterface
     */
    public function freeze($id);

    /**
     * Destroy a service that registered in the container
     *
     * @param string $id ServiceName
     *
     * @throws \buildr\Container\Exception\CannotChangeException
     */
    public function destroy($id);

    /**
     * Allow to modify an object in the container. The given service is injected into a closure and
     * tha closure must return the modified object
     *
     * @param string $id Service name
     * @param \Closure $callback
     *
     * @return \buildr\Container\ContainerInterface
     * @throws \buildr\Container\Exception\NotFoundException
     */
    public function extend($id, \Closure $callback);


    /**
     * Try to instantiate a new object from the given class and figure out
     * all its dependency through PHP Reflection API
     *
     * @param string $class The class FQCN
     * @param array $predefinedParameters Allows you to force constructor parameter
     *
     * <pre>
     * The forced constructor parameters used primary, the order of parameter does not matter
     * because its defined by variable name as the array element key.
     *
     * Example:
     *
     * public function __construct($nullParam, \Hello $world, $param = 'world', $anotherNullParam);
     *
     * In this example we want to force the 2 null parameter.
     *
     * Container::construct('Class', ['anotherNullParam' => 'string 2', 'nullParam' => 'string 1']);
     *
     * Of course, you can override parameter that can be resolved automatically, like $world
     * </pre>
     *
     * @return object
     */
    public function construct($class, $predefinedParameters = []);

    /**
     * Inject the class properties automatically that can by injected and the docComment
     * contains the @Wire operator.
     *
     * This method also takes default parameters, see Constainer::construct() method for example.
     *
     * @param object $object
     * @param array $predefinedParameters
     *
     * @throws \buildr\Container\Exception\NotFoundException
     * @throws \buildr\Container\Exception\InjectionException
     */
    public function inject($object, $predefinedParameters = []);

    /**
     * Register a service provider in container. When provider defined interface for class
     * This alos registered as alias(es).
     *
     * @param \buildr\ServiceProvider\ServiceProviderInterface $provider
     */
    public function register(ServiceProviderInterface $provider) ;

}
