<?php namespace buildr\Http\Request\Parameter;

use buildr\Http\Request\Parameter\HttpParameterInterface;

/**
 * HTTP parameter base class
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Http\Request\Parameter
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class BaseHttpParameter implements HttpParameterInterface {

    /**
     * @type string
     */
    private $parameterKey;

    /**
     * @type string
     */
    private $parameterValue;

    /**
     * Constructor
     *
     * @param string $key
     * @param string $value
     */
    public function __construct($key, $value) {
        $this->parameterKey = $key;
        $this->parameterValue = $value;
    }

    /**
     * Returns the value key as string
     *
     * @return string
     */
    public function getName() {
        return $this->parameterKey;
    }

    /**
     * Returns the current object as string
     *
     * @return string
     */
    public function __toString() {
        return (string) $this->parameterValue;
    }

    /**
     * Returns the current value as boolean
     *
     * @return bool
     */
    public function asBool() {
        return (bool) $this->parameterValue;
    }

    /**
     * Returns the current value as int
     *
     * @return int
     */
    public function asInt() {
        return (int) $this->parameterValue;
    }

    /**
     * Returns the current value as a floating point value
     *
     * @return float
     */
    public function asFloat() {
        return (float) $this->parameterValue;
    }

    /**
     * Return the current value as string
     *
     * @return string
     */
    public function asString() {
        return (string) $this;
    }

    /**
     * Return the unmodified, value
     *
     * @return mixed
     */
    public function asRaw() {
        return $this->parameterValue;
    }

    /**
     * Split the value on $delimiter and returns the result
     *
     * @param string $delimiter
     *
     * @return array
     */
    public function asArray($delimiter = ',') {
        $parts = explode($delimiter, $this->parameterValue);

        return $parts;
    }

}
