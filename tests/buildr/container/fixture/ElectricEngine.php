<?php namespace buildr\tests\container\fixture;

class ElectricEngine implements EngineInterface {

    public $sound;

    public function __construct(ElectricEngineSound $sound) {
        $this->sound = $sound->get();
    }

    public function getSound() {
        return $this->sound();
    }

    public function __toString() {
        return (string) $this->getSound();
    }
}
