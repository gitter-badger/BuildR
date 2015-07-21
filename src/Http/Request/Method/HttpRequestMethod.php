<?php namespace buildr\Http\Request\Method;

use buildr\Utils\Enum\BaseEnumeration;

/**
 * Request methods enumeration
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Http\Method
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @codeCoverageIgnore
 */
class HttpRequestMethod extends BaseEnumeration {

    const GET = 'get';
    const POST = 'post';
    const CONNECT = 'connect';
    const DELETE = 'delete';
    const HEAD = 'head';
    const OPTIONS = 'options';
    const PATCH = 'patch';
    const PUT = 'put';
    const TRACE = 'trace';

    /**
     * PHP magic method
     *
     * @return string
     */
    public function __toString() {
        return strtoupper($this->value);
    }

}
