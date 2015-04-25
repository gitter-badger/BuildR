<?php namespace buildr\tests\reflection\fixture;

/**
 * Dummy class
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Reflection\Fixture
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class reflectorTestClass {

    private $bar;

    public $baz;

    public function __construct($bar, $baz = FALSE) {
        $this->bar = $bar;
        $this->baz = $baz;
    }

    private function getBar() {
        return $this->bar;
    }

    public function getBarPublic() {
        return $this->bar;
    }

    public static function getString() {
        return "String";
    }

    public static function staticTestMethod($value = "defaultValue") {
        return $value;
    }

    /**
     * @testValueInteger 1
     * @testValueString string
     * @testValueBool true
     */
    public function annotationTesterOne() {
        return NULL;
    }

    /**
     * @testJson [1,"false",false]
     * @testJsonTwo {"x":5}
     */
    public function annotationTesterJson() {
        return NULL;
    }

    /**
     * @key value
     * @key value2
     */
    public function annotationTestMultiVal() {
        return NULL;
    }

}