<?php namespace buildr\Shell\Value;

/**
 * Flag
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Shell\Value
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Flag {

    /**
     * @type string
     */
    private $name;

    /**
     * @type string|null
     */
    private $value;

    const PREFIX = '-';

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
