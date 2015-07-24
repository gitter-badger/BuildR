<?php namespace buildr\Http\Response;

use buildr\Http\Constants\HttpResponseCode;
use buildr\Http\Constants\HttpProtocolVersion;
use buildr\Http\Response\ContentType\HttpContentTypeInterface;

/**
 * Response interface
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Http\Response
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface ResponseInterface {

    /**
     * Set the header write-out behaviour. If you set the Header write-out
     * to TRUE, it means that returned headers will be prepended to response,
     * if the corresponding content type returns the header.
     *
     * @param $value bool
     */
    public function setHeaderWriteOut($value);

    /**
     * Returns that the current response allow header
     * write-out or not.
     *
     * @return bool
     */
    public function isAllowingHeaderWriteOut();

    /**
     * Set the message body
     *
     * @param mixed $body
     */
    public function setBody($body);

    /**
     * Same as the getBody() function, but is always return the unmodified,
     * original body content.
     *
     * @return mixed
     */
    public function getRawBody();

    /**
     * Returns the HttpHeaderBag. This allow you to manipulate headers
     *
     * @return \buildr\Http\Header\ResponseHeaderBag
     */
    public function getHeaderBag();

    /**
     * Send out the response, prepare, write out headers and
     * returns the finished response body
     *
     * @return mixed
     */
    public function send();

    /**
     * Shorthand function for send()
     *
     * @return string
     */
    public function __toString();

    /**
     * Set the status code of this response, by default this setter override
     * the status text, to the set status message. If you want to disable this
     * functionality, set the $disableStatusTextOverride to TRUE. If you disable
     * this override and not set the statusText manually the response MAYBE broken.
     *
     * @param \buildr\Http\Constants\HttpResponseCode $status
     * @param bool $disableStatusTextOverride
     */
    public function setStatusCode(HttpResponseCode $status, $disableStatusTextOverride = FALSE);

    /**
     * Set the status text manually
     *
     * @param mixed $statusText
     */
    public function setStatusText($statusText);

    /**
     * Set the response HTTP protocol version
     *
     * @param \buildr\Http\Constants\HttpProtocolVersion $version
     */
    public function setProtocolVersion(HttpProtocolVersion $version);

    /**
     * Set the response content type. This is not so useful for returning plain text content
     * but useful if you want to encode the content before output. If you set the content type
     * using this method, by default override the content type string to the specified
     * content type. To disable this functionality set the secondary parameter to TRUE
     * and use the setContentTypeText() method to set the content type manually.
     *
     * @param \buildr\Http\Response\ContentType\HttpContentTypeInterface $contentType
     * @param bool $disableTypeOverride
     */
    public function setContentType(HttpContentTypeInterface $contentType, $disableTypeOverride = FALSE);

    /**
     * Set the content type text to the specified. Useful for type overriding.
     *
     * @param string $contentType
     */
    public function setContentTypeString($contentType);

}
