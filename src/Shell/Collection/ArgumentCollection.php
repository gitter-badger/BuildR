<?php namespace buildr\Shell\Collection;

use buildr\Shell\Value\Argument;

/**
 * BuildR - PHP based continuous integration server
 *
 * Argument collection
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Shell\Collection
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ArgumentCollection {

    /**
     * @type array
     */
    private $arguments = [];

    /**
     * @return string
     */
    public function __toString() {
        return implode(' ', $this->arguments);
    }

    /**
     * Add an argument to the argument collection
     *
     * @param \buildr\Shell\Value\Argument $argument
     */
    public function addArgument(Argument $argument) {
        $this->arguments[] = $argument;
    }

}
