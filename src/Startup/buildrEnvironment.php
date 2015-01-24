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
        if(self::$isInitialized === FALSE) {
            self::detectEnvironment();
        }

        return self::$detectedEnvironment;
    }

    /**
     * Detect the environment by domain
     */
    private static final function detectEnvironment() {
        $environmentConfig = Config::get('buildr.environment');
        $detectedEnvironment = static::E_DEV;

        $host = $_SERVER['HTTP_HOST'];

        foreach($environmentConfig as $environment => $domains) {
            foreach($domains as $domain) {
                if($domain == $host) {
                    $detectedEnvironment = $environment;
                }
            }
        }

        self::$detectedEnvironment = $detectedEnvironment;
    }

}