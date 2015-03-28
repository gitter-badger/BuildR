<?php namespace buildr\Cache\Item;

/**
 * BuildR - PHP based continuous integration server
 *
 * CacheItemInterface
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Cache
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
interface CacheItemInterface {

    /**
     * Return the value of the current cache entry
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Return the key of the current cache entry
     *
     * @return string
     */
    public function getKey();

    /**
     * Determine of the current cache entry is hit
     *
     * @return bool
     */
    public function isHit();

    /**
     * Determine of the current cache entry is miss
     *
     * @return bool
     */
    public function isMiss();

}
