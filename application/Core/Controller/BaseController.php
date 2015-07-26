<?php namespace buildr\Application\Core\Controller;

use buildr\Http\Request\RequestInterface;

/**
 * Base controller
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Application\Core\Controller
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class BaseController {

    protected $request;

    public function __construct(RequestInterface $req) {
        $this->request = $req;
    }

}
