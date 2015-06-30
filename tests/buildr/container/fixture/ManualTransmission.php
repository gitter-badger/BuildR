<?php namespace buildr\tests\container\fixture;

class ManualTransmission implements TransmissionInterface {

    const MAX_GEAR = 5;

    public $gear = 0;

    public function shiftUp() {
        if($this->gear < self::MAX_GEAR) {
            $this->gear++;
        }
    }

    public function shiftDown() {
        if($this->gear > 0) {
            $this->gear--;
        }
    }

    public function getGear() {
        return $this->gear;
    }
}
