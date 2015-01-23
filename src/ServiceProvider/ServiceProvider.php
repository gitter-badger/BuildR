<?php namespace buildr\ServiceProvider;

use buildr\Registry\Registry;

class ServiceProvider {

    /**
     * Register service providers by array
     *
     * @param array $providersArray
     */
    public static function registerProvidersByArray($providersArray) {
        foreach($providersArray as $providerClassName) {
            self::registerByName($providerClassName);
        }
    }

    /**
     * Register a service in the registry be its class name
     *
     * @param string $providerName
     */
    public static function registerByName($providerName) {
        $providerClass = self::checkProviderByName($providerName);

        $ObjectToRegister = $providerClass->register();
        $bindingName = $providerClass->getBindingName();

        Registry::bindClass($bindingName, $ObjectToRegister);
    }

    /**
     * Check provider by name and return the instated class
     *
     * @param string $providerName
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