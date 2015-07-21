<?php namespace buildr\Http\Request\Parameter;

/**
 * Common interface for HTTP parameters
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
 *
 * @codeCoverageIgnore
 */
interface HttpParameterInterface {

    /**
     * Returns the value key as string
     *
     * @return string
     */
    public function getName();

    /**
     * Returns the current object as string
     *
     * @return string
     */
    public function __toString();

    /**
     * Returns the current value as boolean
     *
     * @return bool
     */
    public function asBool();

    /**
     * Returns the current value as int
     *
     * @return int
     */
    public function asInt();

    /**
     * Returns the current value as a floating point value
     *
     * @return float
     */
    public function asFloat();

    /**
     * Return the current value as string
     *
     * @return string
     */
    public function asString();

    /**
     * Split the value on $delimiter and returns the result
     *
     * @param string $delimiter
     *
     * @return array
     */
    public function asArray($delimiter = ',');

}
