<?php namespace buildr\Http\Uri;

use buildr\Utils\StringUtils;
use Psr\Http\Message\UriInterface;

/**
 * PSR-7 URI implementation
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Http\Uri
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Uri implements UriInterface {

    const PATH_SEPARATOR = '/';

    const QUERY_SEPARATOR = '&';

    const QUERY_SEPARATOR_INNER = '=';

    /**
     * @type array
     */
    private $parsedUrl;

    /**
     * @type string
     */
    private $scheme;

    /**
     * @type string
     */
    private $authority;

    /**
     * @type string
     */
    private $host;

    /**
     * @type string|null
     */
    private $port;

    /**
     * @type string
     */
    private $userInfo;

    /**
     * @type string
     */
    private $path;

    /**
     * @type string
     */
    private $query;

    /**
     * @type string
     */
    private $fragment;

    /**
     * Contains all currently supported URI scheme
     * and the corresponding port
     *
     * @type array
     */
    private $supportedSchemes = [
        'http' => 80,
        'https' => 443,
    ];

    /**
     * Construct
     *
     * @param string $url The raw uri
     */
    public function __construct($url) {
        if(filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            throw new \InvalidArgumentException('Failed to parse the given URI!');
        }

        $this->parsedUrl = parse_url($url);

        $this->scheme = $this->getFilteredScheme();
        $this->host = $this->getFilteredHost();
        $this->port = $this->getFilteredPort();
        $this->userInfo = $this->getFilteredUserInfo();
        $this->path = $this->getFilteredPath();
        $this->query = $this->getFilteredQuery();
        $this->authority = $this->createAuthority();
        $this->fragment = isset($this->parsedUrl['fragment'])
            ? $this->filterFragment($this->parsedUrl['fragment'])
            : '';
    }

    /**
     * Retrieve the scheme component of the URI.
     *
     * If no scheme is present, this method MUST return an empty string.
     *
     * The value returned MUST be normalized to lowercase, per RFC 3986
     * Section 3.1.
     *
     * The trailing ":" character is not part of the scheme and MUST NOT be
     * added.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-3.1
     * @return string The URI scheme.
     */
    public function getScheme() {
        return $this->scheme;
    }

    /**
     * Retrieve the authority component of the URI.
     *
     * If no authority information is present, this method MUST return an empty
     * string.
     *
     * The authority syntax of the URI is:
     *
     * <pre>
     * [user-info@]host[:port]
     * </pre>
     *
     * If the port component is not set or is the standard port for the current
     * scheme, it SHOULD NOT be included.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-3.2
     * @return string The URI authority, in "[user-info@]host[:port]" format.
     */
    public function getAuthority() {
        return $this->authority;
    }

    /**
     * Retrieve the user information component of the URI.
     *
     * If no user information is present, this method MUST return an empty
     * string.
     *
     * If a user is present in the URI, this will return that value;
     * additionally, if the password is also present, it will be appended to the
     * user value, with a colon (":") separating the values.
     *
     * The trailing "@" character is not part of the user information and MUST
     * NOT be added.
     *
     * @return string The URI user information, in "username[:password]" format.
     */
    public function getUserInfo() {
        return $this->userInfo;
    }

    /**
     * Retrieve the host component of the URI.
     *
     * If no host is present, this method MUST return an empty string.
     *
     * The value returned MUST be normalized to lowercase, per RFC 3986
     * Section 3.2.2.
     *
     * @see http://tools.ietf.org/html/rfc3986#section-3.2.2
     * @return string The URI host.
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * Retrieve the port component of the URI.
     *
     * If a port is present, and it is non-standard for the current scheme,
     * this method MUST return it as an integer. If the port is the standard port
     * used with the current scheme, this method SHOULD return null.
     *
     * If no port is present, and no scheme is present, this method MUST return
     * a null value.
     *
     * If no port is present, but a scheme is present, this method MAY return
     * the standard port for that scheme, but SHOULD return null.
     *
     * @return null|int The URI port.
     */
    public function getPort() {
        return $this->port;
    }

    /**
     * Retrieve the path component of the URI.
     *
     * The path can either be empty or absolute (starting with a slash) or
     * rootless (not starting with a slash). Implementations MUST support all
     * three syntaxes.
     *
     * Normally, the empty path "" and absolute path "/" are considered equal as
     * defined in RFC 7230 Section 2.7.3. But this method MUST NOT automatically
     * do this normalization because in contexts with a trimmed base path, e.g.
     * the front controller, this difference becomes significant. It's the task
     * of the user to handle both "" and "/".
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.3.
     *
     * As an example, if the value should include a slash ("/") not intended as
     * delimiter between path segments, that value MUST be passed in encoded
     * form (e.g., "%2F") to the instance.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.3
     * @return string The URI path.
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Retrieve the query string of the URI.
     *
     * If no query string is present, this method MUST return an empty string.
     *
     * The leading "?" character is not part of the query and MUST NOT be
     * added.
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.4.
     *
     * As an example, if a value in a key/value pair of the query string should
     * include an ampersand ("&") not intended as a delimiter between values,
     * that value MUST be passed in encoded form (e.g., "%26") to the instance.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.4
     * @return string The URI query string.
     */
    public function getQuery() {
        return $this->query;
    }

    /**
     * Retrieve the fragment component of the URI.
     *
     * If no fragment is present, this method MUST return an empty string.
     *
     * The leading "#" character is not part of the fragment and MUST NOT be
     * added.
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.5.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.5
     * @return string The URI fragment.
     */
    public function getFragment() {
        return $this->fragment;
    }

    /**
     * Return an instance with the specified scheme.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified scheme.
     *
     * Implementations MUST support the schemes "http" and "https" case
     * insensitively, and MAY accommodate other schemes if required.
     *
     * An empty scheme is equivalent to removing the scheme.
     *
     * @param string $scheme The scheme to use with the new instance.
     *
     * @return self A new instance with the specified scheme.
     * @throws \InvalidArgumentException for invalid or unsupported schemes.
     */
    public function withScheme($scheme) {
        $newInstance = clone $this;
        $newInstance->parsedUrl = NULL;
        $newInstance->scheme = $this->getFilteredScheme($scheme);
        $newInstance->refreshAuthority();

        return $newInstance;
    }

    /**
     * Return an instance with the specified user information.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified user information.
     *
     * Password is optional, but the user information MUST include the
     * user; an empty string for the user is equivalent to removing user
     * information.
     *
     * @param string $user The user name to use for authority.
     * @param null|string $password The password associated with $user.
     *
     * @return self A new instance with the specified user information.
     */
    public function withUserInfo($user, $password = NULL) {
        $userInfo = $user;

        if($password !== NULL) {
            $userInfo .= ':' . $password;
        }

        $newInstance = clone $this;
        $newInstance->parsedUrl = NULL;
        $newInstance->userInfo = $userInfo;
        $newInstance->refreshAuthority();

        return $newInstance;
    }

    /**
     * Return an instance with the specified host.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified host.
     *
     * An empty host value is equivalent to removing the host.
     *
     * @param string $host The hostname to use with the new instance.
     *
     * @return self A new instance with the specified host.
     * @throws \InvalidArgumentException for invalid hostnames.
     */
    public function withHost($host) {
        $newInstance = clone $this;
        $newInstance->parsedUrl = NULL;
        $newInstance->host = $this->getFilteredHost($host);
        $newInstance->refreshAuthority();

        return $newInstance;
    }

    /**
     * Return an instance with the specified port.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified port.
     *
     * Implementations MUST raise an exception for ports outside the
     * established TCP and UDP port ranges.
     *
     * A null value provided for the port is equivalent to removing the port
     * information.
     *
     * @param null|int $port The port to use with the new instance; a null value
     *     removes the port information.
     *
     * @return self A new instance with the specified port.
     * @throws \InvalidArgumentException for invalid ports.
     */
    public function withPort($port) {
        $newInstance = clone $this;
        $newInstance->parsedUrl = NULL;
        $newInstance->port = $this->getFilteredPort($port);
        $newInstance->refreshAuthority();

        return $newInstance;
    }

    /**
     * Return an instance with the specified path.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified path.
     *
     * The path can either be empty or absolute (starting with a slash) or
     * rootless (not starting with a slash). Implementations MUST support all
     * three syntaxes.
     *
     * If the path is intended to be domain-relative rather than path relative then
     * it must begin with a slash ("/"). Paths not starting with a slash ("/")
     * are assumed to be relative to some base path known to the application or
     * consumer.
     *
     * Users can provide both encoded and decoded path characters.
     * Implementations ensure the correct encoding as outlined in getPath().
     *
     * @param string $path The path to use with the new instance.
     *
     * @return self A new instance with the specified path.
     * @throws \InvalidArgumentException for invalid paths.
     */
    public function withPath($path) {
        if(!is_string($path)) {
            throw new \InvalidArgumentException('The $path parameter mut be a string!');
        }

        if(StringUtils::contains($path, '?')) {
            throw new \InvalidArgumentException('The new path cant contains query string!');
        }

        if(StringUtils::contains($path, '#')) {
            throw new \InvalidArgumentException('The new path cant contains url fragment!');
        }

        $newInstance = clone $this;
        $newInstance->parsedUrl = NULL;
        $newInstance->path = $this->getFilteredPath($path);
        $newInstance->refreshAuthority();

        return $newInstance;
    }

    /**
     * Return an instance with the specified query string.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified query string.
     *
     * Users can provide both encoded and decoded query characters.
     * Implementations ensure the correct encoding as outlined in getQuery().
     *
     * An empty query string value is equivalent to removing the query string.
     *
     * @param string $query The query string to use with the new instance.
     *
     * @return self A new instance with the specified query string.
     * @throws \InvalidArgumentException for invalid query strings.
     */
    public function withQuery($query) {
        if(!is_string($query)) {
            throw new \InvalidArgumentException('The $query parameter mut be a string!');
        }

        if(StringUtils::contains($query, '#')) {
            throw new \InvalidArgumentException('The new query cant contains url fragment!');
        }

        $newInstance = clone $this;
        $newInstance->parsedUrl = NULL;
        $newInstance->query = $this->getFilteredQuery($query);
        $newInstance->refreshAuthority();

        return $newInstance;
    }

    /**
     * Return an instance with the specified URI fragment.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified URI fragment.
     *
     * Users can provide both encoded and decoded fragment characters.
     * Implementations ensure the correct encoding as outlined in getFragment().
     *
     * An empty fragment value is equivalent to removing the fragment.
     *
     * @param string $fragment The fragment to use with the new instance.
     *
     * @return self A new instance with the specified fragment.
     */
    public function withFragment($fragment) {
        $newInstance = clone $this;
        $newInstance->parsedUrl = NULL;
        $newInstance->fragment = $this->filterFragment($fragment);
        $newInstance->refreshAuthority();

        return $newInstance;
    }

    /**
     * Return the string representation as a URI reference.
     *
     * Depending on which components of the URI are present, the resulting
     * string is either a full URI or relative reference according to RFC 3986,
     * Section 4.1. The method concatenates the various components of the URI,
     * using the appropriate delimiters:
     *
     * - If a scheme is present, it MUST be suffixed by ":".
     * - If an authority is present, it MUST be prefixed by "//".
     * - The path can be concatenated without delimiters. But there are two
     *   cases where the path has to be adjusted to make the URI reference
     *   valid as PHP does not allow to throw an exception in __toString():
     *     - If the path is rootless and an authority is present, the path MUST
     *       be prefixed by "/".
     *     - If the path is starting with more than one "/" and no authority is
     *       present, the starting slashes MUST be reduced to one.
     * - If a query is present, it MUST be prefixed by "?".
     * - If a fragment is present, it MUST be prefixed by "#".
     *
     * @see http://tools.ietf.org/html/rfc3986#section-4.1
     * @return string
     */
    public function __toString() {
        $uri = '';

        if($this->scheme !== '') {
            $uri .= $this->scheme . '://';
        }

        if($this->userInfo !== '') {
            $uri .= $this->userInfo . '@';
        }

        if($this->host !== '') {
            $uri .= $this->host;
        }

        if(!$this->isDefaultPortForThisScheme()) {
            $uri .= ':' . (string) $this->port;
        }

        $uri .= $this->path;

        if($this->query !== '') {
            $uri .= '?' . $this->query;
        }

        if($this->fragment !== '') {
            $uri .= '#' . $this->fragment;
        }

        return $uri;
    }

    /**
     * Filter the scheme.
     *
     * If no scheme is present, this method MUST return an empty string.
     *
     * The value returned MUST be normalized to lowercase, per RFC 3986
     * Section 3.1.
     *
     * The trailing ":" character is not part of the scheme and MUST NOT be
     * added.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-3.1
     *
     * @param null|string $scheme
     *
     * @throws \InvalidArgumentException
     * @return string
     */
    private function getFilteredScheme($scheme = NULL) {
        if($scheme === NULL && isset($this->parsedUrl['scheme'])) {
            $scheme = $this->parsedUrl['scheme'];
        }

        $scheme = rtrim(strtolower($scheme), ':/');

        // @codeCoverageIgnoreStart
        if($scheme == '') {
            return '';
        }
        // @codeCoverageIgnoreEnd

        if(!isset($this->supportedSchemes[$scheme])) {
            throw new \InvalidArgumentException('This scheme (' . $scheme . ') is not supported!');
        }

        return $scheme;
    }

    /**
     * Filter the host.
     *
     * If no host is present, this method MUST return an empty string.
     *
     * The value returned MUST be normalized to lowercase, per RFC 3986
     * Section 3.2.2.
     *
     * @see http://tools.ietf.org/html/rfc3986#section-3.2.2
     *
     * @param null|string $host
     *
     * @return string
     */
    private function getFilteredHost($host = NULL) {
        if($host === NULL && isset($this->parsedUrl['host'])) {
            $host = $this->parsedUrl['host'];
        }

        if($host === NULL) {
            return '';
        }

        return strtolower($host);
    }

    /**
     * Filter the port.
     *
     * If a port is present, and it is non-standard for the current scheme,
     * this method MUST return it as an integer. If the port is the standard port
     * used with the current scheme, this method SHOULD return null.
     *
     * If no port is present, and no scheme is present, this method MUST return
     * a null value.
     *
     * If no port is present, but a scheme is present, this method MAY return
     * the standard port for that scheme, but SHOULD return null.
     *
     * @param string|null $port
     *
     * @throws \InvalidArgumentException
     * @return int|null
     */
    private function getFilteredPort($port = NULL) {
        if($port === NULL && isset($this->parsedUrl['port'])) {
            $port = $this->parsedUrl['port'];
        }

        if($port !== NULL) {
            $port = (int) $port;

            if($port < 1 || $port > 65535) {
                throw new \InvalidArgumentException('The specified port (' . $port . ') is not a valid TCP/UDP port!');
            }

            return $port;
        }

        if(($port === NULL) && (isset($this->supportedSchemes[$this->scheme]))) {
            return $this->supportedSchemes[$this->scheme];
        }

        return NULL;
    }

    /**
     * Filter the user information.
     *
     * If no user information is present, this method MUST return an empty
     * string.
     *
     * If a user is present in the URI, this will return that value;
     * additionally, if the password is also present, it will be appended to the
     * user value, with a colon (":") separating the values.
     *
     * The trailing "@" character is not part of the user information and MUST
     * NOT be added.
     *
     * @param null|string $userName
     * @param string|null $password
     *
     * @return string
     */
    private function getFilteredUserInfo($userName = NULL, $password = '') {
        if($userName === NULL && isset($this->parsedUrl['user'])) {
            $userName = $this->parsedUrl['user'];
        }

        if($password === '' && isset($this->parsedUrl['pass'])) {
            $password = $this->parsedUrl['pass'];
        }

        $result = '';

        if($userName !== NULL) {
            $result = $userName;

            if($password !== '') {
                $result .= ':' . $password;
            }
        }

        return $result;
    }

    /**
     * Filter the path.
     *
     * The path can either be empty or absolute (starting with a slash) or
     * rootless (not starting with a slash). Implementations MUST support all
     * three syntaxes.
     *
     * Normally, the empty path "" and absolute path "/" are considered equal as
     * defined in RFC 7230 Section 2.7.3. But this method MUST NOT automatically
     * do this normalization because in contexts with a trimmed base path, e.g.
     * the front controller, this difference becomes significant. It's the task
     * of the user to handle both "" and "/".
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.3.
     *
     * As an example, if the value should include a slash ("/") not intended as
     * delimiter between path segments, that value MUST be passed in encoded
     * form (e.g., "%2F") to the instance.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.3
     *
     * @param string|null $path
     *
     * @return string
     */
    private function getFilteredPath($path = NULL) {
        if($path === NULL && isset($this->parsedUrl['path'])) {
            $path = $this->parsedUrl['path'];
        }

        if($path === NULL) {
            return self::PATH_SEPARATOR;
        }

        $pathItems = explode(self::PATH_SEPARATOR, $path);

        foreach($pathItems as $key => $value) {
            $pathItems[$key] = rawurlencode($value);
        }

        return self::PATH_SEPARATOR . implode(self::PATH_SEPARATOR, array_filter($pathItems));
    }

    /**
     * Filter the query.
     *
     * If no query string is present, this method MUST return an empty string.
     *
     * The leading "?" character is not part of the query and MUST NOT be
     * added.
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.4.
     *
     * As an example, if a value in a key/value pair of the query string should
     * include an ampersand ("&") not intended as a delimiter between values,
     * that value MUST be passed in encoded form (e.g., "%26") to the instance.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.4
     *
     * @param string|null $query
     *
     * @return string
     */
    private function getFilteredQuery($query = NULL) {
        if($query === NULL && isset($this->parsedUrl['query'])) {
            $query = $this->parsedUrl['query'];
        }

        if($query === NULL) {
            return '';
        }

        $queryItems = explode(self::QUERY_SEPARATOR, $query);

        foreach($queryItems as $key => $value) {
            $queryParameters = explode(self::QUERY_SEPARATOR_INNER, $value);
            $queryItems[$key] = $this->filterFragment($queryParameters[0]);

            if(count($queryParameters) == 2) {
                $queryItems[$key] .= self::QUERY_SEPARATOR_INNER . $this->filterFragment($queryParameters[1]);
            }
        }

        return implode(self::QUERY_SEPARATOR, $queryItems);
    }

    /**
     * Filter a given fragment.
     *
     * If no fragment is present, this method MUST return an empty string.
     *
     * The leading "#" character is not part of the fragment and MUST NOT be
     * added.
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.5.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.5
     *
     * @param string $fragment
     *
     * @return string
     */
    private function filterFragment($fragment) {
        $alreadyEncoded = preg_match('~%[0-9A-F]{2}~i', $fragment);

        if($alreadyEncoded) {
            return rawurlencode(urldecode(str_replace(['+','='], ['%2B','%3D'], $fragment)));
        }

        return rawurlencode($fragment);
    }

    /**
     * Creates the proper authority parameter using the previously
     * calculated and filtered values.
     *
     * @return string
     */
    private function createAuthority() {
        // @codeCoverageIgnoreStart
        if($this->host === '') {
            return '';
        }
        // @codeCoverageIgnoreEnd

        $authorityString = $this->host;

        if($this->userInfo !== '') {
            $authorityString = $this->userInfo . '@' . $authorityString;
        }

        if(!$this->isDefaultPortForThisScheme()) {
            $authorityString .= ':' . $this->port;
        }

        return $authorityString;
    }

    /**
     * Called when using with*() methods and re-created the authority string
     * on the cloned object, to match to new uri details.
     */
    private function refreshAuthority() {
        $this->authority = $this->createAuthority();
    }

    /**
     * By the detected scheme and port, determines that
     * the current uri port is it the default ft thi scheme.
     *
     * @return bool
     */
    private function isDefaultPortForThisScheme() {
        if(($this->scheme !== '')
            && ($this->port !== NULL)
            && (isset($this->supportedSchemes[$this->scheme]))
            && ($this->supportedSchemes[$this->scheme] == $this->port)) {
            return TRUE;
        }

        return FALSE;
    }

}
