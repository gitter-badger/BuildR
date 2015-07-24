<?php namespace buildr\Http\Request;

use buildr\Http\Header\HeaderBag;
use buildr\Http\Request\Method\HttpRequestMethod;
use buildr\Http\Request\Parameter\GlobalParameter;
use buildr\Http\Request\Parameter\HeaderParameter;
use buildr\Http\Request\Parameter\PostParameter;
use buildr\Http\Request\Parameter\QueryParameter;
use buildr\Http\Uri\GlobalsUriResolver;
use buildr\Http\Uri\Uri;
use buildr\Utils\StringUtils;

/**
 * Request
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Http\Request
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Request implements RequestInterface {

    /**
     * @type array
     */
    private $globals;

    /**
     * @type \buildr\Http\Header\HeaderBag
     */
    private $headers;

    /**
     * @type array
     */
    private $cookies;

    /**
     * @type array
     */
    private $query;

    /**
     * @type array
     */
    private $postFields;

    /**
     * @type resource
     */
    private $inputStream;

    /**
     * @type \buildr\Http\Request\Method\HttpRequestMethod
     */
    private $method;

    /**
     * @type \buildr\Http\Uri\Uri
     */
    private $uri;

    /**
     * @type bool
     */
    private $isSecure = FALSE;

    /**
     * Create the request from the provided super-globals
     *
     * @param array $globals
     * @param array $cookies
     * @param array $query
     * @param array $postFields
     * @param array $files
     * @param NULL|resource $stream
     */
    public function createFromGlobals($globals = [],
                                      $cookies = [],
                                      $query = [],
                                      $postFields = [],
                                      $files  = [],
                                      $stream = NULL) {
        $this->globals = $globals;
        $this->headers = new HeaderBag($this->collectHeaders($globals));
        $this->cookies = $cookies;
        $this->query = $query;
        $this->postFields = $postFields;

        $this->method = (isset($globals['REQUEST_METHOD'])) ?
            new HttpRequestMethod(strtoupper($globals['REQUEST_METHOD'])) :
            HttpRequestMethod::GET();

        if($stream === NULL) {
            $this->inputStream = fopen('php://input', 'r');
        }

        $this->uri = new Uri((string) new GlobalsUriResolver($this->globals));

        if(isset($globals['REQUEST_SCHEME']) && $globals['REQUEST_SCHEME'] === 'https') {
            $this->isSecure = TRUE;
        }
    }

    /**
     * Returns the current input stream as resource
     *
     * @return resource
     */
    public function getInputStream() {
        return $this->inputStream;
    }

    /**
     * Get a specified post param from the request. If the param is
     * not preset in the request this will returns the default
     *
     * @param string $name
     * @param mixed $default
     *
     * @return \buildr\Http\Request\Parameter\PostParameter
     */
    public function getPostParam($name, $default = NULL) {
        if($this->hasPostParam($name)) {
            return new PostParameter($name, $this->postFields[$name]);
        }

        return new PostParameter($name, $default);
    }

    /**
     * Determines that the given post param exist
     * in the request or not
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasPostParam($name) {
        if(isset($this->postFields[$name])) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Returns all post fields in request
     * as an associative array
     *
     * @return array
     */
    public function getAllPostParam() {
        return $this->postFields;
    }

    /**
     * Determines that the given query param exist
     * in the request or not
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasQueryParam($name) {
        if(isset($this->query[$name])) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Get a specified query param from the request. If the param is
     * not preset in the request this will returns the default
     *
     * @param string $name
     * @param mixed $default
     *
     * @return \buildr\Http\Request\Parameter\QueryParameter
     */
    public function getQueryParam($name, $default = NULL) {
        if($this->hasQueryParam($name)) {
            return new QueryParameter($name, $this->query[$name]);
        }

        return new QueryParameter($name, $default);
    }

    /**
     * Returns all query params in request
     * as an associative array
     *
     * @return array
     */
    public function getAllQueryParam() {
        return $this->query;
    }

    /**
     * Determines that the given cookie exist
     * in the request or not
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasCookie($name) {
        if(isset($this->cookies[$name])) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Get a specified cookie from the request. If the cookie is
     * not preset in the request this will returns the default
     *
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function getCookie($name, $default = NULL) {
        if($this->hasCookie($name)) {
            return $this->cookies[$name];
        }

        return $default;
    }

    /**
     * Returns all cookie in request
     * as an associative array
     *
     * @return array
     */
    public function getAllCookie() {
        return $this->cookies;
    }

    /**
     * Get a specified header from the request. In first, this function try
     * to get header from detected HTTP headers, but if not found, use the
     * $_SERVER super-global to find the specified entry. If the header is
     * not preset in the header fields, or the $_SERVER returns the
     * default value.
     *
     * @param string $param
     * @param mixed $default
     *
     * @return \buildr\Http\Request\Parameter\HeaderParameter
     */
    public function getHeader($param, $default = NULL) {
        if($this->hasHeader($param)) {
            return new HeaderParameter($param, $this->headers->get($param));
        }

        return new HeaderParameter($param, $default);
    }

    /**
     * Determines that the given header exist
     * in the request or not
     *
     * @param string $param
     *
     * @return bool
     */
    public function hasHeader($param) {
        if($this->headers->has($param)) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Returns all detected header in request
     * as an associative array
     *
     * @return array
     */
    public function getAllHeaders() {
        return $this->headers->getAll();
    }

    /**
     * Return the raw $_SERVER super-global content
     *
     * @return array
     */
    public function getAllGlobal() {
        return $this->globals;
    }

    /**
     * Determines that the request has the following global
     *
     * @param string $param
     *
     * @return bool
     */
    public function hasGlobal($param) {
        if(isset($this->globals[$param])) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Return a specified element from the $_SERVER super-global
     *
     * @param string $param
     * @param mixed $default
     *
     * @return \buildr\Http\Request\Parameter\GlobalParameter
     */
    public function getGlobal($param, $default = NULL) {
        if($this->hasGlobal($param)) {
            return new GlobalParameter($param, $this->globals[$param]);
        }

        return new GlobalParameter($param, $default);
    }

    /**
     * Returns the headerBag
     *
     * @return \buildr\Http\Header\HeaderBag
     */
    public function getHeaderBag() {
        return $this->headers;
    }

    /**
     * Find out that thi given request is
     * secure or not (Basically, requested with HTTPS)
     *
     * @return bool
     */
    public function isSecure() {
        return $this->isSecure;
    }

    /**
     * Returns the current URI
     *
     * @return \buildr\Http\Uri\Uri
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * Compare the current request type
     *
     * @param \buildr\Http\Request\Method\HttpRequestMethod $method
     *
     * @return bool
     */
    public function is(HttpRequestMethod $method) {
        return ($this->method->getValue() === $method->getValue());
    }

    /**
     * Returns the current request method
     *
     * @return \buildr\Http\Request\Method\HttpRequestMethod
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Get all headers from the given $_SERVER superglobal, and
     * only collect the RFC-2616 defined headers
     *
     * @param array $server
     *
     * @return array
     */
    private function collectHeaders($server) {
        $headers = [];

        foreach($server as $name => $value) {
            //Do no care with cookies in header
            if(StringUtils::contains($name, 'HTTP_COOKIE')) {
                continue;
            }

            if(StringUtils::startWith($name, 'HTTP_')) {
                $name = str_replace('_', ' ', StringUtils::trimFromBeginning($name, 'HTTP_'));
                $name = str_replace(' ', '-', ucwords(strtolower($name)));
                $headers[$name] = $value;
            }

            if(StringUtils::startWith($name, 'CONTENT_')) {
                $name = str_replace('_', ' ', $name);
                $name = str_replace(' ', '-', ucwords(strtolower($name)));
                $headers[$name] = $value;
            }
        }

        return $headers;
    }

}
