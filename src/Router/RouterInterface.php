<?php namespace buildr\Router;

/**
 * Router Interface
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Router
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface RouterInterface {

    /**
     * Register a new route in the router.
     * One rout can listen for multiple request method. use | (pipe) character to
     * separate the methods.
     *
     * @param string $methods
     * @param string $pattern
     * @param callable|string $callback
     */
    public function add($methods, $pattern, $callback);

    /**
     * Run the router loop
     */
    public function run();

    /**
     * Return the response that returned from the given closure or controller class
     * If the class not returns a response object this function will returns NULL.
     *
     * @return \buildr\Http\Response\ResponseInterface|NULL
     */
    public function getResponse();
}
