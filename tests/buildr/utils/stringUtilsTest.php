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

    /**
     * @dataProvider containsProvider
     */
    public function testContains($word, $part) {
        $this->assertTrue(\buildr\Utils\String\StringUtils::contains($word, $part));
    }

    /**
     * @dataProvider charAtProvider
     */
    public function testCharAt($word, $position, $char) {
        $givenChar = \buildr\Utils\String\StringUtils::charAt($word, $position);
        $this->assertEquals($char, $givenChar);
    }

    /**
     * @dataProvider patternProvider
     */
    public function testPattern($word, $pattern) {
        $res = \buildr\Utils\String\StringUtils::match($word, $pattern);
        $this->assertTrue($res);
    }

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

    public function containsProvider() {
        $return = [];

        for($i = 1 ; $i <= 25 ; $i++) {
            $word = $this->faker->word;
            $wordLen = strlen($word);

            if($wordLen < 4) {
                $i--;
            } else {
                $containPart = substr($word, 1, -2);
                $return[] =  [$word, $containPart];
            }


        }

        return $return;
    }

    public function charAtProvider() {
        $return = [];

        for($i = 1 ; $i <= 25 ; $i++) {
            $word = $this->faker->word;
            $wordLen = strlen($word);
            $position = rand(1, $wordLen);
            $char = str_split($word)[$position-1];

            $return[] = [$word, $position, $char];
        }

        return $return;
    }

    public function patternProvider() {
        $return = [];

        $return[] = ["Lorem", "Lo.em"];
        $return[] = ["Lorem", "Lo*m"];
        $return[] = ["Lorem", ".orem"];
        $return[] = ["Lorem", "L.r.m"];
        $return[] = ["Lorem", "*r.m"];

        return $return;
    }

}
