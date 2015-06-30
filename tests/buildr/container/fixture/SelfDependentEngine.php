<?php namespace buildr\tests\container\fixture;

class SelfDependentEngine {

    public function __construct(SelfDependentEngine $engine) {

    }

}
