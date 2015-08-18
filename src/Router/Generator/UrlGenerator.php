<?php namespace buildr\Router\Generator;

use buildr\Router\Map\RouteMap;
use buildr\Router\Route\Route;
use buildr\Router\Exception\RouteNotFoundException;

/**
 * Route generator
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Router\Generator
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class UrlGenerator {

    protected $map;

    protected $route;

    protected $url;

    protected $data;

    protected $repl;

    protected $raw;

    protected $basepath;

    public function __construct(RouteMap $map, $basepath = null) {
        $this->map = $map;
        $this->basepath = $basepath;
    }

    public function generate($name, $data = []) {
        return $this->build($name, $data, false);
    }

    public function generateRaw($name, $data = []) {
        return $this->build($name, $data, true);
    }

    protected function build($name, $data, $raw) {
        $this->raw = $raw;
        $this->route = $this->map->getRoute($name);

        $this->buildUrl();

        $this->repl = [];
        $this->data = array_merge($this->route->defaults, $data);

        $this->buildTokenReplacements();
        $this->buildOptionalReplacements();

        $this->url = strtr($this->url, $this->repl);

        $this->buildWildcardReplacement();

        return $this->url;
    }

    protected function buildUrl() {
        $this->url = $this->basepath . $this->route->path;
        $host = $this->route->host;

        if(!$host) {
            return;
        }

        $this->url = '//' . $host . $this->url;
        $secure = $this->route->secure;

        if($secure === null) {
            return;
        }

        $protocol = $secure ? 'https:' : 'http:';
        $this->url = $protocol . $this->url;
    }

    protected function buildTokenReplacements() {
        foreach($this->data as $key => $val) {
            $this->repl["{{$key}}"] = $this->encode($val);
        }
    }

    protected function buildOptionalReplacements() {
        preg_match('#{/([a-z][a-zA-Z0-9_,]*)}#', $this->url, $matches);

        if(!$matches) {
            return;
        }

        $names = explode(',', $matches[1]);
        $key = $matches[0];
        $this->repl[$key] = $this->buildOptionalReplacement($names);
    }

    protected function buildOptionalReplacement($names) {
        $repl = '';

        foreach($names as $name) {
            if(!isset($this->data[$name])) {
                return $repl;
            }

            $repl .= '/' . $this->encode($this->data[$name]);
        }

        return $repl;
    }

    protected function buildWildcardReplacement() {
        $wildcard = $this->route->wildcard;

        if($wildcard && isset($this->data[$wildcard])) {
            $this->url = rtrim($this->url, '/');

            foreach($this->data[$wildcard] as $val) {
                $this->url .= '/' . $this->encode($val);
            }
        }
    }

    protected function encode($val) {
        if($this->raw) {
            return $val;
        }

        return is_scalar($val) ? rawurlencode($val) : null;
    }

}
