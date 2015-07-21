<?php namespace buildr\Http\Header; 

use buildr\Http\Header\HeaderBag;

/**
 * Response Header Bag
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Http\Header
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ResponseHeaderBag extends HeaderBag {

    public function __construct(array $headers = []) {
        parent::__construct($headers);
    }

    /**
     * Add a new header to the stack. If the given header exist
     * in the stack try to replace it, expect if the
     * $replace value set to FALSE
     *
     * @param string $name
     * @param string $value
     * @param bool $replace
     *
     * @return bool
     */
    public function add($name, $value, $replace = TRUE) {
        if((!isset($this->headers[$name])) || (isset($this->headers[$name]) && $replace === TRUE)) {
            $this->headers[$name] = $value;

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Removes a specified header from the stack
     *
     * @param string $name
     */
    public function remove($name) {
        if($this->has($name)) {
            unset($this->headers[$name]);
        }
    }
}
