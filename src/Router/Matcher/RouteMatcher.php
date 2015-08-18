<?php namespace buildr\Router\Matcher;

use buildr\Http\Request\RequestInterface;
use buildr\Router\Map\RouteMap;
use buildr\Router\Route\Route;
use buildr\Router\Rule\RuleIterator;

/**
 * Router matcher
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Router\Matcher
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class RouteMatcher {

    /**
     * @type \buildr\Router\Map\RouteMap
     */
    private $map;

    /**
     * @type \buildr\Router\Rule\RuleIterator
     */
    private $ruleIterator;

    /**
     * @type \buildr\Router\Route\Route|FALSE
     */
    protected $matchedRoute;

    /**
     * The first of the closest-matching failed routes.
     *
     * @type \buildr\Router\Route\Route
     */
    protected $failedRoute;

    /**
     * The score of the closest-matching failed route.
     *
     * @type int
     */
    protected $failedScore = 0;

    /**
     * Constructor
     *
     * @param \buildr\Router\Map\RouteMap $map
     * @param \buildr\Router\Rule\RuleIterator $ruleIterator
     */
    public function __construct(RouteMap $map, RuleIterator $ruleIterator) {
        $this->map = $map;
        $this->ruleIterator = $ruleIterator;
    }

    /**
     * Returns a route that matches the request
     *
     * @param \buildr\Http\Request\RequestInterface $request
     *
     * @return \buildr\Router\Route\Route|FALSE
     */
    public function match(RequestInterface $request) {
        $this->matchedRoute = FALSE;
        $this->failedRoute = NULL;
        $this->failedScore = 0;

        $path = $request->getUri()->getPath();

        foreach($this->map as $name => $routePrototype) {
            $route = $this->requestRoute($request, $routePrototype, $name, $path);

            if($route) {
                return $route;
            }
        }

        return FALSE;
    }

    /**
     * Matches a request to a route
     *
     * @param \buildr\Http\Request\RequestInterface $request
     * @param \buildr\Router\Route\Route $routePrototype
     * @param string $name
     * @param string $path
     *
     * @return \buildr\Router\Route\Route|FALSE
     */
    public function requestRoute(RequestInterface $request, Route $routePrototype, $name, $path) {
        if(!$routePrototype->isRouteable) {
            return;
        }

        $route = clone $routePrototype;
        return $this->applyRules($request, $route, $name, $path);
    }

    /**
     * @param \buildr\Http\Request\RequestInterface $request
     * @param \buildr\Router\Route\Route $route
     * @param string $name
     * @param string $path
     *
     * @return \buildr\Router\Route\Route|FALSE
     */
    public function applyRules(RequestInterface $request, Route $route, $name, $path) {
        $score = 0;

        foreach ($this->ruleIterator as $rule) {
            if(!$rule($request, $route)) {
                return $this->ruleFailed($request, $route, $name, $path, $rule, $score);
            }

            $score++;
        }

        return $this->routeMatched($route, $name, $path);
    }

    /**
     * @param \buildr\Http\Request\RequestInterface $request
     * @param \buildr\Router\Route\Route $route
     * @param string $name
     * @param string $path
     * @param string $rule
     * @param int $score
     *
     * @return bool
     */
    public function ruleFailed(RequestInterface $request, Route $route, $name, $path, $rule, $score) {
        $ruleClass = get_class($rule);
        $route->failedRule($ruleClass);

        if(!$this->failedRoute || $score > $this->failedScore) {
            $this->failedRoute = $route;
            $this->failedScore = $score;
        }

        return FALSE;
    }

    /**
     * @param \buildr\Router\Route\Route $route
     * @param string $name
     * @param string $path
     *
     * @return \buildr\Router\Route\Route
     */
    public function routeMatched(Route $route, $name, $path) {
        $this->matchedRoute = $route;

        return $route;
    }

    /**
     * Get the first of the closest-matching failed routes.
     *
     * @return \buildr\Router\Route\Route
     */
    public function getFailedRoute() {
        return $this->failedRoute;
    }

    /**
     * Returns the result of the call to match() again so you don't need to
     * run the matching process again.
     *
     * @return \buildr\Router\Route\Route|FALSE|NULL
     */
    public function getMatchedRoute() {
        return $this->matchedRoute;
    }

}
