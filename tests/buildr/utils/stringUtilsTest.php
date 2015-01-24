<?php

/**
 * BuildR - PHP based continuous integration server
 *
 * Unit test for the String utilities in buildr
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class stringUtilsTest extends buildr_TestCase {

    public function startWithProvider() {
        $return = [];

        for($i = 1 ; $i <= 25 ; $i++) {
            $word = $this->faker->word;
            $start = substr($word, 0, 2);

            $return[] =  [$word, $start];
        }

        return $return;
    }

    public function endWithProvider() {
        $return = [];

        for($i = 1 ; $i <= 25 ; $i++) {
            $word = $this->faker->word;
            $end = substr($word, -1, 2);

            $return[] =  [$word, $end];
        }

        return $return;
    }

    /**
     * @dataProvider startWithProvider
     */
    public function testStartWith($word, $start) {
        $this->assertTrue(\buildr\Utils\String\StringUtils::startWith($word, $start));
    }

    /**
     * @dataProvider endWithProvider
     */
    public function testEndWith($word, $end) {
        $this->assertTrue(\buildr\Utils\String\StringUtils::endWith($word, $end));
    }
}
