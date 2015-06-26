<?php namespace buildr\Application;

use buildr\Container\ContainerInterface;

/**
 * 
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Application
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @codeCoverageIgnore
 */
class Application {

    /**
     * @type \buildr\Container\ContainerInterface
     */
    private static $container;

    /**
     * Set the container instance on the application
     *
     * @param \buildr\Container\ContainerInterface $c
     */
    public static function setContainer(ContainerInterface $c) {
        self::$container = $c;
    }

    /**
     * Get the DI container for application
     *
     * @return \buildr\Container\ContainerInterface
     */
    public static function getContainer() {
        return self::$container;
    }

}
