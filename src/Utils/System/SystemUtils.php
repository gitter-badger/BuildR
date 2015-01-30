<?php namespace buildr\Utils\System;
use buildr\Utils\String\StringUtils;

/**
 * BuildR - PHP based continuous integration server
 *
 * System support helper for PHP module
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Utils\System
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class SystemUtils {

    /**
     * Windows OS type
     */
    const OS_TYPE_WIN = "TYPE_WIN";

    /**
     * *NIX OS type
     */
    const OS_TYPE_NIX = "TYPE_NIX";

    /**
     * Return the support of a SystemModule on current system
     *
     * @param array $extensionModule
     * @return array
     */
    public static final function getExtensionSupport(array $extensionModule) {
        $extensionStates = [];

        /**
         * @var \buildr\Utils\System\Modules\BaseSystemModule $moduleClass
         */
        foreach($extensionModule as $module) {
            $moduleClass = new $module;
            $moduleName = $moduleClass->moduleName;

            if($moduleClass->isSupported()) {
                $extensionStates[$moduleName] = TRUE;
            } else {
                $extensionStates[$moduleName] = $moduleClass->getUnSupportReason();
            }

            return $extensionStates;
        }
    }

    /**
     * return the current operation system type
     *
     * @return string
     */
    public static final function getOsType() {
        if (StringUtils::contains(PHP_OS, "WIN")) {
            return self::OS_TYPE_WIN;
        }

        return self::OS_TYPE_NIX;
    }

}
