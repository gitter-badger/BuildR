<?php namespace buildr\Router\Rule;

use buildr\Http\Request\RequestInterface;
use buildr\Router\Route\AttributeMatchingTrait;
use buildr\Router\Route\Route;

/**
 * Path rule
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Router\Rule
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class PathRule implements RuleInterface {

    protected $route;

    protected $regex;

    protected $basePath;

    use AttributeMatchingTrait;

    public function __construct($basePath = NULL) {
        $this->basePath = $basePath;
    }

    /**
     * Check if the Request matches the Route.
     *
     * @param \buildr\Http\Request\RequestInterface $request The HTTP request.
     * @param \buildr\Router\Route\Route $route The route.
     *
     * @return bool True on success, false on failure.
     */
    public function __invoke(RequestInterface $request, Route $route) {
        $match = preg_match($this->buildRegex($route), $request->getUri()->getPath(), $matches);

        if(!$match) {
            return FALSE;
        }

        $route->attributes($this->getAttributes($matches, $route->wildcard));

        return TRUE;
    }

    protected function getAttributes($matches, $wildcard) {
        $attributes = [];

        foreach($matches as $key => $val) {
            if(is_string($key) && $val !== '') {
                $attributes[$key] = rawurldecode($val);
            }
        }

        if(!$wildcard) {
            return $attributes;
        }

        $attributes[$wildcard] = [];

        if(!empty($matches[$wildcard])) {
            $attributes[$wildcard] = array_map('rawurldecode', explode('/', $matches[$wildcard]));
        }

        return $attributes;
    }

    protected function buildRegex(Route $route) {
        $this->route = $route;
        $this->regex = $this->basePath . $this->route->path;

        $this->setRegexOptionalAttributes();
        $this->setRegexAttributes();
        $this->setRegexWildcard();

        $this->regex = '#^' . $this->regex . '$#';

        return $this->regex;
    }

    protected function setRegexOptionalAttributes() {
        preg_match('#{/([a-z][a-zA-Z0-9_,]*)}#', $this->regex, $matches);

        if($matches) {
            $repl = $this->getRegexOptionalAttributesReplacement($matches[1]);
            $this->regex = str_replace($matches[0], $repl, $this->regex);
        }
    }

    protected function getRegexOptionalAttributesReplacement($list) {
        $list = explode(',', $list);
        $head = $this->getRegexOptionalAttributesReplacementHead($list);
        $tail = '';

        foreach($list as $name) {
            $head .= "(/{{$name}}";
            $tail .= ')?';
        }

        return $head . $tail;
    }

    protected function getRegexOptionalAttributesReplacementHead(&$list) {
        $head = '';

        if(substr($this->regex, 0, 2) == '{/') {
            $name = array_shift($list);
            $head = "/({{$name}})?";
        }

        return $head;
    }

    protected function setRegexWildcard() {
        if(!$this->route->wildcard) {
            return;
        }

        $this->regex = rtrim($this->regex, '/') . "(/(?P<{$this->route->wildcard}>.*))?";
    }

}
