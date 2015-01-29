<?php namespace buildr\Startup;
use buildr\Config\Config;

/**
 * BuildR - PHP based continuous integration server
 *
 * Environment handler
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Startup
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class buildrEnvironment {

    /**
     * Production environment constant
     */
    const E_PROD = "production";

    /**
     * Development environment constant
     */
    const E_DEV = "development";

    /**
     * Default environment on console run
     */
    const E_CONSOLE = "console-default";

    /**
     * @type string
     */
    private static $detectedEnvironment;

    /**
     * @type bool
     */
    private static $isInitialized = FALSE;

    /**
     * Public function to get the detected environment name
     *
     * @return string
     */
    public static final function getEnv() {
        if(self::isRunningFromConsole()) {
            return self::E_CONSOLE;
        }

        if(self::$isInitialized === FALSE) {
            self::detectEnvironment();
            self::$isInitialized = TRUE;
        }

        return self::$detectedEnvironment;
    }

    public static final function setEnv($environment) {
        if(!self::isRunningFromConsole()) {
            throw new \RuntimeException("The setEnv() function is only used if the application is running from console!");
        }

        self::$detectedEnvironment = $environment;
    }

    /**
     * Determine of te current run is initiated from condole, or is a HTTP request
     *
     * @return bool
     */
    public static final function isRunningFromConsole() {
        if(php_sapi_name() === "cli") {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Detect the environment by domain
     */
    private static final function detectEnvironment() {
        $environmentConfig = Config::getEnvDetectionConfig();
        $detectedEnvironment = static::E_DEV;

        $host = $_SERVER['HTTP_HOST'];

        foreach($environmentConfig as $environment => $domains) {
            foreach($domains as $domain) {
                if($domain == $host) {
                    $detectedEnvironment = $environment;
                }
            }
        }

        self::$isInitialized = TRUE;
        self::$detectedEnvironment = $detectedEnvironment;
    }

}
