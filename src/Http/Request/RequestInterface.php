<?php namespace buildr\Http\Request;

use buildr\Http\Request\Method\HttpRequestMethod;

/**
 * Request Interface
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
interface RequestInterface {

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
                                      $stream = NULL);

    /**
     * Returns the current input stream as resource
     *
     * @return resource
     */
    public function getInputStream();

    /**
     * Get a specified post param from the request. If the param is
     * not preset in the request this will returns the default
     *
     * @param string $name
     * @param mixed $default
     *
     * @return \buildr\Http\Request\Parameter\PostParameter
     */
    public function getPostParam($name, $default = NULL);

    /**
     * Determines that the given post param exist
     * in the request or not
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasPostParam($name);

    /**
     * Returns all post fields in request
     * as an associative array
     *
     * @return array
     */
    public function getAllPostParam();

    /**
     * Determines that the given query param exist
     * in the request or not
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasQueryParam($name);

    /**
     * Get a specified query param from the request. If the param is
     * not preset in the request this will returns the default
     *
     * @param string $name
     * @param mixed $default
     *
     * @return \buildr\Http\Request\Parameter\QueryParameter
     */
    public function getQueryParam($name, $default = NULL);

    /**
     * Returns all query params in request
     * as an associative array
     *
     * @return array
     */
    public function getAllQueryParam();

    /**
     * Determines that the given cookie exist
     * in the request or not
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasCookie($name);

    /**
     * Get a specified cookie from the request. If the cookie is
     * not preset in the request this will returns the default
     *
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function getCookie($name, $default = NULL);

    /**
     * Returns all cookie in request
     * as an associative array
     *
     * @return array
     */
    public function getAllCookie();

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
    public function getHeader($param, $default = NULL);

    /**
     * Determines that the given header exist
     * in the request or not
     *
     * @param string $param
     *
     * @return bool
     */
    public function hasHeader($param);

    /**
     * Returns all detected header in request
     * as an associative array
     *
     * @return array
     */
    public function getAllHeaders();

    /**
     * Return the raw $_SERVER super-global content
     *
     * @return array
     */
    public function getAllGlobal();

    /**
     * Determines that the request has the following global
     *
     * @param string $param
     *
     * @return bool
     */
    public function hasGlobal($param);

    /**
     * Return a specified element from the $_SERVER super-global
     *
     * @param string $param
     * @param mixed $default
     *
     * @return \buildr\Http\Request\Parameter\GlobalParameter
     */
    public function getGlobal($param, $default = NULL);

    /**
     * Returns the headerBag
     *
     * @return \buildr\Http\Header\HeaderBag
     */
    public function getHeaderBag();

    /**
     * Find out that thi given request is
     * secure or not (Basically, requested with HTTPS)
     *
     * @return bool
     */
    public function isSecure();

    /**
     * Returns the current URI
     *
     * @return \buildr\Http\Uri\Uri
     */
    public function getUri();

    /**
     * Returns the current request method
     *
     * @return \buildr\Http\Request\Method\HttpRequestMethod
     */
    public function getMethod();

    /**
     * Compare the current request type
     *
     * @param \buildr\Http\Request\Method\HttpRequestMethod $method
     *
     * @return bool
     */
    public function is(HttpRequestMethod $method);

}
