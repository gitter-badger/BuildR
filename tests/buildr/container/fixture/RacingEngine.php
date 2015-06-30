<?php namespace buildr\tests\container\fixture;

class RacingEngine implements EngineInterface {

    public function getSound() {
        return 'Vroooooom';
    }

    public function __toString() {
        return (string) $this->getSound();
    }
}
