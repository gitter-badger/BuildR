<?php namespace buildr\tests\utils;

use \buildr\tests\Buildr_TestCase as BuildRTestCase;
use buildr\Utils\String\Pattern;
use TheSeer\fDOM\Tests\fDOMXPathTest;

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
class stringUtilsTest extends BuildRTestCase {

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
    public function testPattern($word, $pattern, $expected) {
        $res = \buildr\Utils\String\StringUtils::match($word, $pattern);
        $this->assertEquals($expected, $res);
    }

    /**
     * @dataProvider trimBeginningProvider
     */
    public function testTrimBeginning($word, $trimWord, $result) {
        $res = \buildr\Utils\String\StringUtils::trimFromBeginning($word, $trimWord);
        $this->assertEquals($result, $res);
    }

    /**
     * @dataProvider trimEndProvider
     */
    public function testTrimEnd($word, $trimWord, $result) {
        $res = \buildr\Utils\String\StringUtils::trimFromEnd($word, $trimWord);
        $this->assertEquals($result, $res);
    }

    public function testPatternReturnsTheOriginalPattern() {
        $pattern ='Lo.em';
        $patternClass = new Pattern($pattern);

        $this->assertEquals($pattern, $patternClass->getOriginal());
    }

    public function trimEndProvider() {
        $return = [];

        for($i = 1 ; $i <= 25 ; $i++) {
            $word = $this->faker->word;
            $start = substr($word, -2);
            $p = substr($word, 0, -2);

            $return[] =  [$word, $start, $p];
        }

        $return[] = ["testValue", "testValueNotEnd", "testValue"];
        return $return;
    }

    public function trimBeginningProvider() {
        $return = [];

        for($i = 1 ; $i <= 25 ; $i++) {
            $word = $this->faker->word;
            $start = substr($word, 0, 2);
            $p = substr($word, 2);

            $return[] =  [$word, $start, $p];
        }

        $return[] = ["testValue", "notStartTestValue", "testValue"];
        return $return;
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

        $return[] = ["nullValue", ""];
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

        $return[] = ["asd", 4, null];
        return $return;
    }

    public function patternProvider() {
        $return = [];

        $return[] = ["Lorem", "Lo.em", TRUE];
        $return[] = ["Lorem", "Lo*m", TRUE];
        $return[] = ["Lorem", ".orem", TRUE];
        $return[] = ["Lorem", "L.r.m", TRUE];
        $return[] = ["Lorem", "*r.m", TRUE];
        $return[] = ["testValue", "*r.m", FALSE];

        return $return;
    }

}
