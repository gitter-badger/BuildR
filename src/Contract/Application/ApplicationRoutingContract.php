<?php namespace buildr\Contract\Application;

use buildr\Router\Router;

/**
 * Contract for applications routing class
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Contract\Application
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface ApplicationRoutingContract {

    /**
     * This function is called during the initialization. Inside this
     * function you can register all the routes that you application need.
     *
     * @param \buildr\Router\Router $router
     */
    public function register(Router $router);

}
