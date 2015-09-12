<?php namespace buildr\tests\container\fixture;

class InjuredWireCar {

    /**
     * @Wire
     */
    public $engine;

    /**
     * @Wire
     * @var \buildr\tests\container\fixture\ManualTransmission
     */
    public $transmission;

    public function __construct() {

    }

    public function testMethod($depOne, $depTwo) {

    }

}
