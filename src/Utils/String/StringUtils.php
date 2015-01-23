<?php namespace buildr\Utils\String;

/**
 * BuildR - PHP based continuous integration server
 *
 * Utility class for string manipulation
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Utils\String
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class StringUtils {

    /**
     * Checks if the given string start with the given character, or
     * character sequence
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static final function startWith($haystack, $needle) {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }

    /**
     * Checks if the given string ends with the given character, or
     * character sequence
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static final function endWith($haystack, $needle) {
        $needleLength = strlen($needle);
        if ($needleLength == 0) {
            return TRUE;
        }

        return (substr($haystack, - $needleLength) === $needle);
    }

}