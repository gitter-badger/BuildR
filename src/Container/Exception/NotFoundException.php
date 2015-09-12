<?php namespace buildr\Container\Exception;

use Interop\Container\Exception\NotFoundException as InteropNotFoundExceptionInterface;
use \Exception;

/**
 * Container CannotChangeException
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Container\Exception
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class NotFoundException extends Exception implements InteropNotFoundExceptionInterface {

}
