<?php namespace buildr\Utils;

/**
 * Utility class for string manipulation
 *
 * BuildR PHP Framework
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
     *
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
     *
     * @return bool
     */
    public static final function endWith($haystack, $needle) {
        $needleLength = strlen($needle);
        if($needleLength == 0) {
            return TRUE;
        }

        return (substr($haystack, -$needleLength) === $needle);
    }

    /**
     * Check of the given haystack contains the needle, in any position
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static final function contains($haystack, $needle) {
        if(strpos($haystack, $needle) !== FALSE) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * return the letter at the given index, or NULL if no char at this index
     *
     * @param string , $haystack
     * @param int $index
     *
     * @return string|null
     */
    public static function charAt($haystack, $index) {
        $parts = str_split($haystack);

        if(!isset($parts[$index - 1])) {
            return NULL;
        }

        return $parts[$index - 1];
    }

    /**
     * Match the given string with a pattern. For pattern format, see the documentation
     *
     * @param string $string
     * @param string $patternString
     *
     * @return bool
     */
    public static final function match($string, $patternString) {
        $pattern = new Pattern($patternString);
        $regex = $pattern->getRegex();

        if(preg_match($regex, $string) === 1) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Trim the given character sequence from the beginning of the given string
     *
     * @param string $string
     * @param string $needle
     *
     * @return string
     */
    public static final function trimFromBeginning($string, $needle) {
        $needleLength = mb_strlen($needle);

        if(!self::startWith($string, $needle)) {
            return $string;
        }

        return mb_substr($string, $needleLength);
    }

    /**
     * Trim the given character sequence from the end of the given string
     *
     * @param string $string
     * @param string $needle
     *
     * @return string
     */
    public static final function trimFromEnd($string, $needle) {
        $needleLength = mb_strlen($needle);

        if(!StringUtils::endWith($string, $needle)) {
            return $string;
        }

        $needleLength = $needleLength * -1;

        return mb_substr($string, 0, $needleLength);
    }

    /**
     * Substitute a string with the context
     *
     * @param string $input
     * @param array $context
     *
     * @return string
     */
    public static final function substitution($input, $context = []) {
        $replacements = [];

        foreach ($context as $field => $value) {
            $replacements['{' . $field . '}'] = $value;
        }

        return str_replace(array_keys($replacements), array_values($replacements), $input);
    }

}
