<?php namespace buildr\Shell\Value;

/**
 * Argument class
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Shell\Collection
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Argument {

    /**
     * @type string
     */
    private $name;

    /**
     * @type string
     */
    private $value;

    const PREFIX = '--';

    /**
     * Constructor
     *
     * @param string $name
     * @param null|string $value
     */
    public function __construct($name, $value = NULL) {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString() {
        if($this->value === NULL) {
            return sprintf("%s%s", self::PREFIX, $this->name);
        }

        return sprintf("%s%s %s", self::PREFIX, $this->name, escapeshellarg($this->value));
    }

}
