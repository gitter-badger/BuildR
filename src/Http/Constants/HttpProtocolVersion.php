<?php namespace buildr\Http\Constants;

use buildr\Utils\Enum\BaseEnumeration;

/**
 * HTTP protocol enumeration
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
class HttpProtocolVersion extends BaseEnumeration {

    const HTTP_PROTOCOL_VERSION_1 = 'HTTP/1.0';
    const HTTP_PROTOCOL_VERSION_1_1 = 'HTTP/1.1';
    const HTTP_PROTOCOL_VERSION_2 = 'HTTP/2';

}
