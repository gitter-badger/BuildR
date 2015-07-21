<?php namespace buildr\Http\Response\Facade;

use buildr\Facade\Facade;

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
 * @codeCoverageIgnore
 */
class Response extends Facade {

    public function getBindingName() {
        return 'response';
    }

}
