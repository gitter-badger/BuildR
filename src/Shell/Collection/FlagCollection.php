<?php namespace buildr\Shell\Collection;

use buildr\Shell\Value\Flag;

/**
 * BuildR - PHP based continuous integration server
 *
 * Flag collection
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Shell\Collection
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class FlagCollection {

    /**
     * @type array
     */
    private $flags = [];

    /**
     * @return string
     */
    public function __toString() {
        return implode(' ', $this->flags);
    }

    /**
     * Add an argument to the argument collection
     *
     * @param \buildr\Shell\Value\Flag $flag
     */
    public function addFlag(Flag $flag) {
        $this->flags[] = $flag;
    }

}
