<?php namespace buildr\Container\Alias;

/**
 * Container aliases resolver
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Container\Alias
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class AliasResolver {

    /**
     * Stored aliases
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * Create a new alias
     *
     * @param string $alias
     * @param string $origin
     */
    public function alias($alias, $origin) {
        $this->aliases[$alias] = $origin;
    }

    /**
     * Check if the given name is an alias or not
     *
     * @param string $name
     * @return bool
     */
    public function isAlias($name) {
        return isset($this->aliases[$name]) ? TRUE : FALSE;
    }

    /**
     * Returns the origin of the given alias. If the given string
     * is not an alias return the input unmodified.
     *
     * @param string $name
     * @return string
     */
    public function getOrigin($name) {
        if(!$this->isAlias($name)) {
            return $name;
        }

        return($this->aliases[$name]);
    }

}
