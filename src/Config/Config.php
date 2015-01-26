<?php namespace buildr\Config;

use buildr\Config\Exception\InvalidConfigKeyException;
use buildr\Config\Selector\ConfigSelector;
use buildr\Startup\buildrEnvironment;

/**
 * BuildR - PHP based continuous integration server
 *
 * Configuration class
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Config
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Config {

    /**
     * @type bool
     */
    private static $isInitialized = FALSE;

    /**
     * @type string
     */
    private static $configLocation;

    /**
     * @type string
     */
    private static $environmentalConfigLocation;

    /**
     * @type array
     */
    private static $configCache = [];

    /**
     * Initialize this class, its set the proper location of the configuration files root folder
     */
    private static function initialize() {
        if(self::$isInitialized === TRUE) {
            return;
        }

        $currentEnvironment = buildrEnvironment::getEnv();

        //Begin class initialization
        self::$configLocation = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config');
        self::$environmentalConfigLocation = realpath(self::$configLocation . DIRECTORY_SEPARATOR . $currentEnvironment);
    }

    /**
     * Get config for environment detection. This is specific for initialization. Its not call the
     * initialize() method on this class. Its basically allow to me to use environmental base
     * configuration later on initialization
     *
     * @return mixed|string
     */
    public static final function getEnvDetectionConfig() {
        $envConfig = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'environment.php');
        $envConfig = require_once $envConfig;

        return $envConfig;
    }

    /**
     * Get a config value by key
     *
     * @param string $configKey
     * @return mixed
     */
    public static function get($configKey) {
        self::initialize();
        $selector = new ConfigSelector($configKey);

        if(self::isFileAlreadyCached($selector->getFileName())) {
            return self::getFromCache($selector);
        }

        return self::getFromFile($selector);
    }

    /**
     * Decide a file, its already in cache or not
     *
     * @param string $configFile
     * @return bool
     */
    private static function isFileAlreadyCached($configFile) {
        if(isset(self::$configCache[$configFile])) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Get the specified value from the cache
     *
     * @param \buildr\Config\Selector\ConfigSelector $selector
     * @return mixed
     * @throws \buildr\Config\Exception\InvalidConfigKeyException
     */
    private static function getFromCache(ConfigSelector $selector) {
        $cacheContent = self::$configCache[$selector->getFileName()];

        return self::getBySelector($selector->getSelectorArray(), $cacheContent);
    }

    /**
     * Get the specified value from the file, and caches the file content by default
     *
     * @param \buildr\Config\Selector\ConfigSelector $selector
     * @param bool $needCache
     * @return mixed
     * @throws \buildr\Config\Exception\InvalidConfigKeyException
     */
    private static function getFromFile(ConfigSelector $selector, $needCache = TRUE) {
        $fileLocationBase = self::$configLocation . $selector->getFilenameForRequire();
        $fileLocationEnvironmental = self::$environmentalConfigLocation . $selector->getFilenameForRequire();

        if(file_exists($fileLocationEnvironmental)) {
            $fileContentBase = require_once $fileLocationBase;
            $fileContentEnvironmental = require_once $fileLocationEnvironmental;

            $fileContent = array_merge($fileContentBase, $fileContentEnvironmental);
        } else {
            $fileContent = require_once $fileLocationBase;
        }



        if($needCache === TRUE) {
            self::$configCache[$selector->getFileName()] = $fileContent;
        }

        return self::getBySelector($selector->getSelectorArray(), $fileContent);
    }

    /**
     * Process the selector, and return the proper section of the configuration
     *
     * @param $selector
     * @param $configArray
     * @return mixed
     * @throws \buildr\Config\Exception\InvalidConfigKeyException
     */
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