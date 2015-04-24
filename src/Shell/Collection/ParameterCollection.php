<?php namespace buildr\Shell\Collection;

use buildr\Shell\Value\Parameter;

/**
 * BuildR - PHP based continuous integration server
 *
 * Parameter collection
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Shell\Collection
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ParameterCollection {

    /**
     * @type array
     */
    private $parameters = [];

    /**
     * @return string
     */
    public function __toString() {
        return implode(' ', $this->parameters);
    }

    /**
     * Add an argument to the argument collection
     *
     * @param \buildr\Shell\Value\Parameter $parameter
     */
    public function addArgument(Parameter $parameter) {
        $this->parameters[] = $parameter;
    }

}
