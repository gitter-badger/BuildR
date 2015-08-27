<?php namespace buildr\Router\Rule;

/**
 * Route attribute matching trait
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Router\Rule
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
trait AttributeMatchingTrait {

    /**
     *
     * Expands attribute names in the regex to named subpatterns; adds default
     * `null` values for attributes without defaults.
     *
     * @return null
     *
     */
    protected function setRegexAttributes() {
        $find = '#{([a-z][a-zA-Z0-9_]*)}#';
        $attributes = $this->route->attributes;
        $newAttributes = [];
        preg_match_all($find, $this->regex, $matches, PREG_SET_ORDER);

        foreach($matches as $match) {
            $name = $match[1];
            $subpattern = $this->getSubpattern($name);
            $this->regex = str_replace("{{$name}}", $subpattern, $this->regex);

            if(!isset($attributes[$name])) {
                $newAttributes[$name] = NULL;
            }
        }

        $this->route->attributes($newAttributes);
    }
    /**
     *
     * Returns a named subpattern for a attribute name.
     *
     * @param string $name The attribute name.
     *
     * @return string The named subpattern.
     *
     */
    protected function getSubpattern($name) {
        // is there a custom subpattern for the name?
        if(isset($this->route->tokens[$name])) {
            return "(?P<{$name}>{$this->route->tokens[$name]})";
        }

        // use a default subpattern, stop at first dot
        return "(?P<{$name}>[^\.]+)";
    }

}
