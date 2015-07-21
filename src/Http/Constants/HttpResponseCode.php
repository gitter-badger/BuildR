<?php namespace buildr\Http\Constants;

use buildr\Utils\Enum\BaseEnumeration;

/**
 * Response statuses enumeration
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Http\Constants
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class HttpResponseCode extends BaseEnumeration {

    /**
     * 1** Informational
     */
    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;

    /**
     * 2** Success
     */
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NOT_AUTHORITATIVE_INFORMATION = 203;     //Since HTTP 1.1
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;       //RFC-7233

    /**
     * 3** Redirection
     */
    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_SEE_OTHER = 303;     //Since HTTP 1.1
    const HTTP_NOT_MODIFIED = 304;      //RFC-7232
    const HTTP_USE_PROXY = 305;     //Since HTTP 1.1
    const HTTP_SWITCH_PROXY = 306;
    const HTTP_TEMPORARY_REDIRECT = 307;    //Since HTTP 1.1
    const HTTP_PERMANENT_REDIRECT = 308;    //RFC-7538
    const HTTP_RESUME_INCOMPLETE = 308;     //Google proposal for PUT and POST requests

    /**
     * 4** Client Error
     */
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;      //RFC-7235
    const HTTP_PAYMENT_REQUIRED = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;     //RFC-7235
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;       //RFC-7232
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUEST_RANGE_NOT_SATISFIABLE = 416;     //RFC-7233
    const HTTP_EXPECTATION_FAILED = 417;
    const HTTP_MISDIRECTED_REQUEST = 421;       //Since HTTP 2
    const HTTP_UPGRADE_REQUIRED = 426;
    const HTTP_PRECOGNITION_REQUIRED = 428;     //RFC-6585
    const HTTP_TOO_MANY_REQUEST = 429;      //RFC-6585
    const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;       //RFC-6585

    /**
     * 5** Server Error
     */
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMED_OUT = 504;
    const HTTP_HTTP_VERSION_NOT_SUPPORTED = 505;
    const HTTP_VARIANT_ALSO_NEGOTIATES = 506;       //RFC-2295
    const HTTP_BANDWIDTH_LIMIT_EXCEEDED = 509;      //Apache BW limit extension only
    const HTTP_NOT_EXTENDED = 510;      //RFC-2774
    const HTTP_UNKNOWN_ERROR = 520;

    private $messages = [
        //1** Informational
        self::HTTP_CONTINUE => 'Continue',
        self::HTTP_SWITCHING_PROTOCOLS => 'Switching Protocols',

        //2** Success
        self::HTTP_OK => 'Ok',
        self::HTTP_CREATED => 'Created',
        self::HTTP_ACCEPTED => 'Accepted',
        self::HTTP_NOT_AUTHORITATIVE_INFORMATION => 'Non-Authoritative Information',    //Since HTTP 1.1
        self::HTTP_NO_CONTENT => 'No Content',
        self::HTTP_RESET_CONTENT => 'Reset Content',
        self::HTTP_PARTIAL_CONTENT => 'Partial Content',

        //3** Redirection
        self::HTTP_MULTIPLE_CHOICES => 'Multiple Choices',
        self::HTTP_MOVED_PERMANENTLY => 'Moved Permanently',
        self::HTTP_FOUND => 'Found',
        self::HTTP_SEE_OTHER => 'See Other',    //Since HTTP 1.1
        self::HTTP_NOT_MODIFIED => 'Not Modified',      //RFC-7232
        self::HTTP_USE_PROXY => 'Use Proxy',    //Since HTTP 1.1
        self::HTTP_SWITCH_PROXY => 'Switch Proxy',
        self::HTTP_TEMPORARY_REDIRECT => 'Temporary Redirect',      //Since HTTP 1.1
        self::HTTP_PERMANENT_REDIRECT => 'Permanent Redirect',      //RFC-7538
        self::HTTP_RESUME_INCOMPLETE => 'Resume Incomplete',    //Google proposal for PUT and POST requests

        //4** Client Error
        self::HTTP_BAD_REQUEST => 'Bad Request',
        self::HTTP_UNAUTHORIZED => 'Unauthorized',      //RFC-7235
        self::HTTP_PAYMENT_REQUIRED => 'Payment Required',
        self::HTTP_FORBIDDEN => 'Forbidden',
        self::HTTP_NOT_FOUND => 'Not Found',
        self::HTTP_METHOD_NOT_ALLOWED => 'Method Not Allowed',
        self::HTTP_NOT_ACCEPTABLE => 'Not Acceptable',
        self::HTTP_PROXY_AUTHENTICATION_REQUIRED => 'Proxy Authentication Required',    //RFC-7235
        self::HTTP_REQUEST_TIMEOUT => 'Request Timeout',
        self::HTTP_CONFLICT => 'Conflict',
        self::HTTP_GONE => 'Gone',
        self::HTTP_LENGTH_REQUIRED => 'Length Required',
        self::HTTP_PRECONDITION_FAILED => 'Precondition Failed',    //RFC-7232
        self::HTTP_REQUEST_ENTITY_TOO_LARGE => 'Request Entity Too Large',
        self::HTTP_REQUEST_URI_TOO_LONG => 'Request-URI Too Long',
        self::HTTP_UNSUPPORTED_MEDIA_TYPE => 'Unsupported Media Type',
        self::HTTP_REQUEST_RANGE_NOT_SATISFIABLE => 'Requested Range Not Satisfiable',      //RFC-7233
        self::HTTP_EXPECTATION_FAILED => 'Expectation Failed',
        self::HTTP_MISDIRECTED_REQUEST => 'Misdirected Request',    //Since HTTP 2
        self::HTTP_UPGRADE_REQUIRED => 'Upgrade Required',
        self::HTTP_PRECOGNITION_REQUIRED => 'Precondition Required',    //RFC-6585
        self::HTTP_TOO_MANY_REQUEST => 'Too Many Requests',     //RFC-6585
        self::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE => 'Request Header Fields Too Large',    //RFC-6585
        
        //5** Server Error
        self::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error',
        self::HTTP_NOT_IMPLEMENTED => 'Not Implemented',
        self::HTTP_BAD_GATEWAY => 'Bad Gateway',
        self::HTTP_SERVICE_UNAVAILABLE => 'Service Unavailable',
        self::HTTP_GATEWAY_TIMED_OUT => 'Gateway Timeout',
        self::HTTP_HTTP_VERSION_NOT_SUPPORTED => 'HTTP Version Not Supported',
        self::HTTP_VARIANT_ALSO_NEGOTIATES => 'Variant Also Negotiates',    //RFC-2295
        self::HTTP_BANDWIDTH_LIMIT_EXCEEDED => 'Bandwidth Limit Exceeded',      //Apache BW limit extension only
        self::HTTP_NOT_EXTENDED => 'Not Extended',      //RFC-2774
        self::HTTP_UNKNOWN_ERROR => 'Unknown Error',

    ];

    /**
     * Translates the current HTTP status code into a message
     *
     * @return string
     */
    public function getMessage() {
        if(isset($this->messages[$this->value])) {
            return $this->messages[$this->value];
        }

        //This will NEVER happens, but is a needed fallback
        //@codeCoverageIgnoreStart
        return '';
        //@codeCoverageIgnoreEnd
    }

}
