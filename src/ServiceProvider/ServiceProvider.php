<?php namespace buildr\ServiceProvider;

use buildr\Application\Application;
use buildr\Container\Facade\Buildr;

/**
 * Service Provider
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage ServiceProvider
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ServiceProvider {

    /**
     * Register service providers by array
     *
     * @param array $providersArray
     *
     * @throw \InvalidArgumentException
     */
    public static function registerProvidersByArray($providersArray) {
        if(!is_array($providersArray)) {
            throw new \InvalidArgumentException("This method must take an array as argument!");
        }

        foreach ($providersArray as $providerClassName) {
            self::registerByName($providerClassName);
        }
    }

    /**
     * Register a service in the registry be its class name
     *
     * @param string $providerName
     */
    public static function registerByName($providerName) {
        $container = Application::getContainer();
        $providerClass = self::checkProviderByName($providerName);

        $ObjectToRegister = $providerClass->register();
        $bindingName = $providerClass->getBindingName();

        $container->add($bindingName, $ObjectToRegister);

        if(($providedInterfaces = $providerClass->provides()) !== NULL) {
            foreach($providedInterfaces as $interfaceClass) {
                $container->bind($interfaceClass, $bindingName, TRUE);
            }
        }
    }

    /**
     * Check provider by name and return the instated class
     *
     * @param string $providerName
     *
     * @return \buildr\ServiceProvider\ServiceProviderInterface;
     */
    private static function checkProviderByName($providerName) {
        if(!class_exists($providerName)) {
            throw new \RuntimeException("The provider class ({$providerName}) not found!");
        }

        $providerClass = new $providerName;

        if(!($providerClass instanceof ServiceProviderInterface)) {
            throw new \RuntimeException("Provider ({$providerName}) must be implement ServiceProviderInterface!");
        }

        return $providerClass;
    }

}
