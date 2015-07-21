<?php namespace buildr\Utils\Enum;

use BadMethodCallException;
use ReflectionClass;
use UnexpectedValueException;

/**
 * Enumeration base class
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Utils\Enum
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
abstract class BaseEnumeration {

    /**
     * @type array
     */
    private static $cache = [];

    /**
     * @type string
     */
    protected $value;

    /**
     * Constructor
     *
     * @param string $value
     */
    public function __construct($value) {
        if(!$this->isValid($value)) {
            throw new UnexpectedValueException('The enumeration not contains key like this: ' . $value);
        }

        $this->value = $value;
    }

    /**
     * Return the key of the current value
     *
     * @return null|string
     */
    public function getKey() {
        return self::find($this->value);
    }

    /**
     * Return the current value
     *
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Validate the value of the enumeration
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value) {
        return in_array($value, self::toArray());
    }

    /**
     * PHP magic method
     *
     * @return string
     */
    public function __toString() {
        return (string) $this->value;
    }

    /**
     * Make an array from the current enumeration class
     *
     * @return mixed
     */
    public static function toArray() {
        $enumClass = get_called_class();

        if(!array_key_exists($enumClass, self::$cache)) {
            $reflector = new ReflectionClass($enumClass);
            self::$cache[$enumClass] = $reflector->getConstants();
        }

        return self::$cache[$enumClass];
    }

    /**
     * Find a key by the enumeration value
     *
     * @param string $value
     *
     * @return null|string
     */
    public static function find($value) {
        return array_search($value, self::toArray(), TRUE);
    }

    /**
     * Returns all key from the enumeration
     *
     * @return array
     */
    public static function getKeys() {
        return array_keys(self::toArray());
    }

    /**
     * Return a key existence in the current enumeration
     *
     * @param string $key
     *
     * @return bool
     * @throw \BadMethodCallException
     */
    public static function isValidKey($key) {
        if(!is_string($key)) {
            throw new BadMethodCallException('The key must be a string!');
        }

        return array_key_exists($key, self::toArray());
    }

    /**
     * Return a new instance from this class, constructed by the given value
     *
     * @param $name
     * @param $arguments
     *
     * @return static
     * @throw \BadMethodCallException
     */
    public static function __callStatic($name, $arguments) {
        if(defined("static::$name")) {
            return new static(constant("static::$name"));
        }

        throw new BadMethodCallException('The enumeration not contains the following constant: ' . $name);
    }

}
