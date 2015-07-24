<?php namespace buildr\Http\Request\Facade;

use buildr\Facade\Facade;

/**
 * Request facade
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Http\Request\Facade
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @method static NULL createFromGlobals() Create the request from the provided super-globals
 * @method static resource getInputStream() Returns the current input stream as resource
 * @method static \buildr\Http\Request\Parameter\PostParameter getPostParam(string $name, mixed $default = NULL) getPostParam(string $name) Get a specified post param from the request. If the param is not preset in the request this will returns the default
 * @method static bool hasPostParam(string $name) Determines that the given post param exist in the request or not
 * @method static array getAllPostParam() Returns all post fields in request as an associative array
 * @method static bool hasQueryParam(string $name) Determines that the given query param exist in the request or not
 * @method static \buildr\Http\Request\Parameter\QueryParameter getQueryParam(string $name, mixed $default = NULL) Get a specified query param from the request. If the param is not preset in the request this will returns the default
 * @method static array getAllQueryParam() Returns all query params in request as an associative array
 * @method static bool hasCookie(string $name) Determines that the given cookie exist in the request or not
 * @method static mixed getCookie(string $name, mixed $default = NULL) Get a specified cookie from the request. If the cookie is not preset in the request this will returns the default
 * @method static array getAllCookie() Returns all cookie in request as an associative array
 * @method static \buildr\Http\Request\Parameter\HeaderParameter getHeader(string $param, mixed $default = NULL) Get a specified header from the request. In first, this function try to get header from detected HTTP headers, but if not found, use the $_SERVER super-global to find the specified entry. If the header is not preset in the header fields, or the $_SERVER returns the default value.
 * @method static bool hasHeader(string $param) Determines that the given header exist in the request or not
 * @method static array getAllHeaders() Returns all detected header in request as an associative array
 * @method static array getAllGlobal() Return the raw $_SERVER super-global content
 * @method static bool hasGlobal(string $param) Determines that the request has the following global
 * @method static \buildr\Http\Request\Parameter\GlobalParameter getGlobal(string $param, mixed $default = NULL) Return a specified element from the $_SERVER super-global
 * @method static \buildr\Http\Header\HeaderBag getHeaderBag() Returns the headerBag
 * @method static bool isSecure() Find out that thi given request is secure or not (Basically, requested with HTTPS)
 * @method static \buildr\Http\Uri\Uri getUri() Returns the current URI
 * @method static bool is(\buildr\Http\Request\Method\HttpRequestMethod $method) Compare the current request type
 * @method static \buildr\Http\Request\Method\HttpRequestMethod getMethod() Returns the current request method
 *
 * @codeCoverageIgnore
 */
class Request extends Facade {

    public function getBindingName() {
        return 'request';
    }

}
