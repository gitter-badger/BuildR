<?php namespace buildr\Router;

use buildr\Application\Application;
use buildr\Http\Request\RequestInterface;

/**
 * Main request router
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
class Router implements RouterInterface {

    /**
     * @type \buildr\Http\Request\RequestInterface
     */
    private $request;

    /**
     * @type string
     */
    private $baseRoute = '';

    /**
     * @type array
     */
    private $routes = [];

    /**
     * @type \buildr\Http\Response\ResponseInterface|NULL
     */
    private $response;

    /**
     * @type string|NULL
     */
    private $notFoundController;

    /**
     * Constructor
     *
     * @param \buildr\Http\Request\RequestInterface $request
     * @param string|NULL $notFoundController
     */
    public function __construct(RequestInterface $request, $notFoundController = NULL) {
        $this->request = $request;
        $this->notFoundController = $notFoundController;
    }

    /**
     * Register a new route in the router.
     * One rout can listen for multiple request method. use | (pipe) character to
     * separate the methods.
     *
     * @param string $methods
     * @param string $pattern
     * @param callable|string $callback
     */
    public function add($methods, $pattern, $callback) {
        $pattern = $this->baseRoute . '/' . trim($pattern, '/');
        $pattern = ($this->baseRoute) ? rtrim($pattern, '/') : $pattern;

        foreach(explode('|', $methods) as $method) {
            $this->routes[$method][] = [
                'pattern' => $pattern,
                'callback' => $callback,
            ];
        }
    }

    /**
     * Run the router loop
     */
    public function run() {
        $handledCount = 0;
        $currentMethod = $this->request->getMethod()->getValue();

        if(isset($this->routes[$currentMethod])) {
            $handledCount = $this->handle($this->routes[$currentMethod]);
        }

        //If the router match 0 URL it will try to execute the 404 controller
        if($handledCount === 0 && $this->notFoundController !== NULL) {
            $this->runCallback($this->notFoundController, []);
        }
    }

    /**
     * Return the response that returned from the given closure or controller class
     * If the class not returns a response object this function will returns NULL.
     *
     * @return \buildr\Http\Response\ResponseInterface|NULL
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * Handle the matched route and execute the given callback
     * or controller action
     *
     * @param array $routes
     *
     * @return int
     */
    private function handle($routes) {
        $handledCount = 0;

        $uri = $this->getRelativeUri();

        foreach($routes as $route) {
            if (preg_match_all('#^' . $route['pattern'] . '$#', $uri, $matches, PREG_OFFSET_CAPTURE)) {
                $matches = array_slice($matches, 1);

                $parameters = array_map(function($match, $index) use($matches) {
                    if (isset($matches[$index+1]) && isset($matches[$index+1][0]) && is_array($matches[$index+1][0])) {
                        return trim(substr($match[0][0], 0, $matches[$index+1][0][1] - $match[0][1]), '/');
                    } else {
                        return (isset($match[0][0]) ? trim($match[0][0], '/') : null);
                    }
                }, $matches, array_keys($matches));

                $this->runCallback($route['callback'], $parameters);

                $handledCount++;

                return $handledCount;

                break;
            }
        }

        return 0;
    }

    /**
     * Run the given callback. Its be a closure or a controller and action is string format
     * The controller action definition is the following:
     *
     * fully\Qualified\Controller\Name::actionName
     *
     * @param callable|string $function
     * @param array $parameters
     */
    private function runCallback($function, $parameters) {
        if(is_string($function)) {
            $callbackData = explode('::', $function);

            $controller = Application::getContainer()->construct($callbackData[0]);
            $function = [$controller, $callbackData[1]];
        }

        $this->response = call_user_func_array($function, $parameters);
    }

    /**
     * Returns the current request relative URI
     *
     * @return string
     */
    private function getRelativeUri() {
        $base = implode('/', array_slice(explode('/', $this->request->getGlobal('SCRIPT_NAME', '/index.php')), 0, -1)) . '/';
        $uri = substr($this->request->getUri()->getPath(), strlen($base));

        return '/' . trim($uri, '/');
    }

}
