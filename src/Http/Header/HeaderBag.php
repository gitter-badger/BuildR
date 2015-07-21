<?php namespace buildr\Http\Header;

use Traversable;

/**
 * Header Bag
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
class HeaderBag implements \IteratorAggregate {

    const HEADER_PROTOCOL = 'HEADER_PROTOCOL';

    const HEADER_STATUS_CODE = 'STATUS_CODE';

    const HEADER_STATUS_TEXT = 'STATUS_TEXT';

    /**
     * @type array
     */
    protected $headers = [];

    /**
     * Constructor. In the first parameter you can pass all the header. This class us immutable
     * that means this class not allows to modify its data. Use the ResponseHeaderBag
     * if you want to modify or add new headers
     *
     * @param array $headers
     */
    public function __construct(array $headers = []) {
        $this->headers = $headers;
    }

    /**
     * Returns all specified header
     *
     * @return array
     */
    public function getAll() {
        return $this->headers;
    }

    /**
     * Return a specified header value from the bag. If the $fullFormat
     * is set to TRUE, this function returns not only the value, but the
     * full header line.
     *
     * @param string $name
     * @param bool $fullFormat
     *
     * @return string|NULL
     */
    public function get($name, $fullFormat = FALSE) {
        if($this->has($name)) {
            if($fullFormat) {
                return $name . ': ' . $this->headers[$name];
            }

            return $this->headers[$name];
        }

        return NULL;
    }

    /**
     * Determines that the given header exist in the stack or not.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name) {
        return (isset($this->headers[$name])) ? TRUE : FALSE;
    }

    /**
     * Returns an array, that contains all specified header name
     *
     * @return array
     */
    public function keys() {
        return array_keys($this->headers);
    }

    /**
     * Retrieve an external iterator
     *
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or <b>Traversable</b>
     */
    public function getIterator() {
        return new \ArrayIterator($this->headers);
    }

}
