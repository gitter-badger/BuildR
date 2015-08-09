<?php namespace buildr\Http\Response\Facade;

use buildr\Facade\Facade;

// @codingStandardsIgnoreFile
/**
 * Response facade
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Http\Response\Facade
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @method static bool setHeaderWriteOut(bool $value) Set the header write-out behaviour. If you set the Header write-out to TRUE, it means that returned headers will be prepended to response, if the corresponding content type returns the header.
 * @method static bool isAllowingHeaderWriteOut() Returns that the current response allow header write-out or not.
 * @method static NULL setBody(mixed $body) Set the message body
 * @method static mixed getRawBody() Same as the getBody() function, but is always return the unmodified, original body content.
 * @method static \buildr\Http\Header\ResponseHeaderBag getHeaderBag() Returns the HttpHeaderBag. This allow you to manipulate headers
 * @method static mixed send() Send out the response, prepare, write out headers and returns the finished response body
 * @method static NULL setStatusCode(\buildr\Http\Constants\HttpResponseCode $status, bool $disableStatusTextOverride = FALSE) Set the status code of this response, by default this setter override the status text, to the set status message. If you want to disable this functionality, set the $disableStatusTextOverride to TRUE. If you disable this override and not set the statusText manually the response MAYBE broken.
 * @method static mixed setStatusText(string $statusText) Set the status text manually
 * @method static NULL setProtocolVersion(\buildr\Http\Constants\HttpProtocolVersion $version) Set the response HTTP protocol version
 * @method static NULL setContentType(\buildr\Http\Response\ContentType\HttpContentTypeInterface $contentType, bool $disableTypeOverride = FALSE) Set the response content type. This is not so useful for returning plain text content but useful if you want to encode the content before output. If you set the content type using this method, by default override the content type string to the specified content type. To disable this functionality set the secondary parameter to TRUE and use the setContentTypeText() method to set the content type manually.
 * @method static NULL setContentTypeString(string $contentType) Set the content type text to the specified. Useful for type overriding.
 * @method static \buildr\Http\Response\ResponseInterface html(string $body) Helper method to easily return HTML responses.
 * @method static \buildr\Http\Response\ResponseInterface json(array $body) Helper method to easily return JSON responses.
 *
 * @codeCoverageIgnore
 */
class Response extends Facade {

    public function getBindingName() {
        return 'response';
    }

}
