<?php namespace buildr\tests;

use Faker\Factory;

/**
 * BuildR - PHP based continuous integration server
 *
 * Basic testCase for easily unit testing
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Buildr_TestCase extends \PHPUnit_Framework_TestCase {

    /**
     * @var \Faker\Generator
     */
    protected $faker = NULL;

    public function __construct($name = null, array $data = array(), $dataName = '') {
        $this->faker = Factory::create();

        parent::__construct($name, $data, $dataName);
    }


    protected function setUp() {

    }

    protected function tearDown() {

    }

}
