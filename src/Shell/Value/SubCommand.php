<?php namespace buildr\Shell\Value;

/**
 * BuildR - PHP based continuous integration server
 *
 * Sub command
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Shell\Value
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class SubCommand {

    /**
     * @type string
     */
    private $value;

    /**
     * Constructor
     *
     * @param string $value
     */
    public function __construct($value) {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->value;
    }

}
