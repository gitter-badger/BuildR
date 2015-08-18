<?php namespace buildr\Router\Rule; 

use \Iterator;

/**
 * Rule Iterator
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
class RuleIterator implements Iterator {

    protected $rules = [];

    public function __construct(array $rules = []) {
        $this->rules = $rules;
    }

    public function set(array $rules) {
        $this->rules = [];

        foreach($rules as $rule) {
            $this->append($rule);
        }
    }

    public function append(callable $rule) {
        $this->rules[] = $rule;
    }

    public function prepend(callable $rule) {
        array_unshift($this->rules, $rule);
    }

    public function current() {
        $rule = current($this->rules);

        if($rule instanceof RuleInterface) {
            return $rule;
        }

        $key = key($this->rules);
        $factory = $this->rules[$key];
        $rule = $factory();

        if($rule instanceof RuleInterface) {
            $this->rules[$key] = $rule;
            return $rule;
        }

        $message = gettype($rule);
        $message .= ($message != 'object') ?: ' of type ' . get_class($rule);
        $message = "Expected RuleInterface, got {$message} for key {$key}";
        throw new \UnexpectedValueException($message);
    }

    public function key() {
        return key($this->rules);
    }

    public function next() {
        next($this->rules);
    }

    public function rewind() {
        reset($this->rules);
    }

    public function valid() {
        return current($this->rules) !== FALSE;
    }

}
