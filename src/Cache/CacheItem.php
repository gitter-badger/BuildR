<?php namespace buildr\Cache;

use \buildr\Cache\CacheItemInterface;

/**
 * BuildR - PHP based continuous integration server
 *
 * Common cache item
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Cache
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class CacheItem implements CacheItemInterface {

    /**
     * @type string
     */
    private $key;

    /**
     * @type mixed
     */
    private $value;

    /**
     * @type bool
     */
    private $hit = FALSE;

    /**
     * Constructor
     *
     * @param string $key
     * @param mixed $value
     * @param bool $hit
     */
    public function __construct($key, $value, $hit) {
        $this->key = $key;
        $this->value = $value;
        $this->hit = $hit;
    }

    /**
     * Return the value of the current cache entry
     *
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Return the key of the current cache entry
     *
     * @return string
     */
    public function getKey() {
        return $this->key;
    }

    /**
     * Determine of the current cache entry is hit
     *
     * @return bool
     */
    public function isHit() {
        return ($this->hit === FALSE) ? FALSE : TRUE;
    }

    /**
     * Determine of the current cache entry is miss
     *
     * @return bool
     */
    public function isMiss() {
        return ($this->hit === FALSE) ? TRUE : FALSE;
    }
}
