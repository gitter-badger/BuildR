<?php namespace buildr\Http\Uri;

/**
 * Resolver class that re-creates the current request URI by analyzing
 * the $_SERVER super-global
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
class GlobalsUriResolver {

    /**
     * @type string
     */
    private $globals;

    /**
     * @type string
     */
    private $scheme;

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
    private $requestUri;

    /**
     * Constructor
     *
     * @param $serverGlobals
     */
    public function __construct($serverGlobals) {
        $this->globals = $serverGlobals;

        $this->scheme = $this->getScheme();
        $this->host = $this->getHost();
        $this->port = $this->getPort();
        $this->requestUri = $this->getRequestUri();
    }

    /**
     * Retrieves the schema from global, this try to detect HTTPS
     * queries behind proxy.
     *
     * @return string
     */
    private function getScheme() {
        if((isset($this->globals['HTTPS']) && $this->globals['HTTPS'] !== 'off')
            || (isset($this->globals['HTTP_X_FORWAREDED_PROTO']) && $this->globals['HTTP_X_FORWAREDED_PROTO'] === 'https')) {
            return 'https';
        }

        return 'http';
    }

    /**
     * Retrieve the host name from the globals. If the
     * globals contains the 'SERVER_NAME' property, always return
     * that parameter.
     *
     * If not, globals always contains the HOST header, 'HTTP_HOST'
     * but sometimes it contains the port number, separated by a colon ':'
     * This function explodes this property by the colon character, and
     * returns the given array first element, that always by the host name.
     *
     * @return string
     */
    private function getHost() {
        if(isset($this->globals['SERVER_NAME'])) {
            return $this->globals['SERVER_NAME'];
        }

        $parts = explode(':', $this->globals['HTTP_HOST']);
        return (string) $parts[0];
    }

    /**
     * Returns the request port. If the 'SERVER_PORT' is
     * not set, returns null.
     *
     * @return null|int
     */
    private function getPort() {
        if(isset($this->globals['SERVER_PORT'])) {
            return $this->globals['SERVER_PORT'];
        }

        return NULL;
    }

    /**
     * Return the full request URI from the globals, if is
     * not present, return a root path '/'
     *
     * @return string
     */
    private function getRequestUri() {
        if (isset($this->globals['REQUEST_URI'])) {
            return $this->globals['REQUEST_URI'];
        }

        return '/';
    }

    /**
     * Makes the full URI by the detected properties.
     *
     * @return string
     */
    public function __toString() {
        $port = ($this->port !== NULL) ? ':' . $this->port : '';

        return $this->scheme . '://' . $this->host . $port . $this->requestUri;
    }

}
