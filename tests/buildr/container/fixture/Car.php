<?php namespace buildr\tests\container\fixture;

class Car {

    public $engine;

    public $transmission;

    public function __construct(EngineInterface $engine, TransmissionInterface $transmission) {
        $this->engine = $engine;
        $this->transmission = $transmission;
    }

}
