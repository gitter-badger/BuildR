<?php namespace buildr\Config;

use buildr\Config\Exception\InvalidConfigKeyException;
use buildr\Config\Selector\ConfigSelector;

class Config {

    private static $isInitialized = FALSE;

    private static $configLocation;

    private static $configCache = [];

    private static function initialize() {
        if(self::$isInitialized === TRUE) {
            return;
        }

        //Begin class initialization
        self::$configLocation = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config');
    }

    public static function get($configKey) {
        self::initialize();
        $selector = new ConfigSelector($configKey);

        if(self::isFileAlreadyCached($selector->getFileName())) {
            return self::getFromCache($selector);
        }

        return self::getFromFile($selector);
    }

    private static function isFileAlreadyCached($configFile) {
        if(isset(self::$configCache[$configFile])) {
            return TRUE;
        }

        return FALSE;
    }

    private static function getFromCache(ConfigSelector $selector) {
        $cacheContent = self::$configCache[$selector->getFileName()];

        return self::getBySelector($selector->getSelectorArray(), $cacheContent);
    }

    private static function getFromFile(ConfigSelector $selector, $needCache = TRUE) {
        $fileLocation = self::$configLocation . $selector->getFilenameForRequire();
        $fileContent = require_once $fileLocation;

        if($needCache === TRUE) {
            self::$configCache[$selector->getFileName()] = $fileContent;
        }

        return self::getBySelector($selector->getSelectorArray(), $fileContent);
    }

    private static function getBySelector($selector, $configArray) {
        if(!is_array($selector)) {
            throw new \InvalidArgumentException("Invalid selector!");
        }

        $tmp = $configArray;
        foreach($selector as $key) {
            if(isset($tmp[$key])) {
                $tmp = $tmp[$key];
                continue;
            }

            throw new InvalidConfigKeyException("The following part of the config not found: {$key}!");
        }

        return $tmp;
    }


}