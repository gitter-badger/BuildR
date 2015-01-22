<?php namespace buildr\Logger;

use buildr\ServiceProvider\ServiceProviderInterface;

/**
 * BuildR - PHP based continuous integration server
 *
 * Service Provider for Logger
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Logger
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class LoggerServiceProvider implements ServiceProviderInterface {

    /**
     * Returns an object that be registered to container
     *
     * @return Object
     */
    public function register() {
        $loggerObject = new Logger();

        return $loggerObject;
    }


    /**
     * Returns the binding name in the container
     *
     * @return string
     */
    public function getBindingName() {
        return "logger";
    }
}