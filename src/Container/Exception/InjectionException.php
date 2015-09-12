<?php namespace buildr\Container\Exception;

use Interop\Container\Exception\ContainerException;
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
class InjectionException extends Exception implements ContainerException {

    /**
     * @type string
     */
    private $valueName;

    /**
     * Set the value name that cant be automatically injected
     *
     * @param string $name
     *
     * @codeCoverageIgnore
     * @return \buildr\Container\Exception\InjectionException
     */
    public function setValue($name) {
        $this->valueName = $name;

        return $this;
    }

    /**
     * Return the value name that cant be automatically injected
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getValue() {
        return $this->valueName;
    }

}

