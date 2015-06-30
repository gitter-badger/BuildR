<?php namespace buildr\tests\container\fixture;

class DieselEngine implements EngineInterface {

    public $sound;

    public function __construct($sound = "VrrRrrr") {
        $this->sound = $sound;
    }

    public function getSound() {
        return $this->sound;
    }

    public function __toString() {
        return (string) $this->getSound();
    }
}
