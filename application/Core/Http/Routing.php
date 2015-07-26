<?php namespace buildr\Application\Core\Http;

use buildr\Contract\Application\ApplicationRoutingContract;
use buildr\Http\Response\Facade\Response;
use buildr\Router\RouterInterface;

/**
 * Routing registry for application
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Application\Core\Http
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Routing implements ApplicationRoutingContract {

    /**
     * This function is called during the initialization. Inside this
     * function you can register all the routes that you application need.
     *
     * @param \buildr\Router\RouterInterface $router
     */
    public function register(RouterInterface $router) {
        $router->add('GET', '/', function() {
            return Response::html('Hello BuildR!');
        });
    }

}
