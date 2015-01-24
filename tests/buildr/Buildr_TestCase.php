<?php

class buildr_TestCase extends PHPUnit_Framework_TestCase {

    /**
     * @var Faker\Generator
     */
    protected $faker = NULL;

    public function __construct($name = null, array $data = array(), $dataName = '') {
        $this->faker = Faker\Factory::create();

        parent::__construct($name, $data, $dataName);
    }


    protected function setUp() {

    }

    protected function tearDown() {

    }

}