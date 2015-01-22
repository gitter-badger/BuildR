<?php namespace buildr\Startup;

class buildrStartup {

    public static function doStartup() {
        //Registering autolaoder
        self::bindInstallPath();
    }

    private static function bindInstallPath() {

    }

    public static function initialize() {
        self::checkBuildrUtilLibrary();
    }



    private static function checkBuildrUtilLibrary() {

    }
}