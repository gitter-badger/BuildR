<?php namespace buildr\Config;

class Config {

    private static $isInitialized = FALSE;

    private $configLocation;

    private static function initialize() {
        if(self::$isInitialized === TRUE) {
            return;
        }

        //Begin class initialization

    }

    public static function get($configKey) {
        die(var_dump($configKey));
    }


}