<?php namespace buildr\tests\container\fixture;

class WireCar {

    /**
     * @Wire
     * @type \buildr\tests\container\fixture\EngineInterface
     */
    public $engine;

    /**
     * @Wire
     * @var \buildr\tests\container\fixture\ManualTransmission
     */
    public $transmission;

    public function __construct() {

    }

}
