<?php namespace buildr\Container\Exception;

/**
 * This exception is thrown when trying to register service name
 * to DI container, when the name is already taken
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
class ServiceAlreadyRegisteredException extends \Exception {

}
