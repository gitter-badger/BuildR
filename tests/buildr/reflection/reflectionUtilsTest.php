<?php namespace buildr\tests\reflection;

use buildr\tests\Buildr_TestCase as BuilderTestCase;
use \Closure;
use buildr\tests\reflection\fixture\reflectorTestClass;
use buildr\Utils\Reflection\ReflectionUtils;

/**
 * BuildR - PHP based continuous integration server
 *
 * Tests for reflection utilities
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Reflection
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class reflectionUtilsTest extends BuilderTestCase {

    public function testItReturnsTheClosureProperly() {
        $closure = ReflectionUtils::getClosureForMethod(reflectorTestClass::class, 'getBar', ['barValue']);

        $this->assertInstanceOf(Closure::class, $closure);
        $this->assertEquals('barValue', call_user_func($closure));
    }

    public function testItReturnTheClosureFromStaticMethodProperly() {
        $closure = ReflectionUtils::getClosureForMethod(reflectorTestClass::class, 'staticTestMethod', ['barValue']);

        $this->assertInstanceOf(Closure::class, $closure);
        $this->assertEquals('defaultValue', call_user_func($closure));
        $this->assertEquals('overriddenValue', call_user_func_array($closure, ['overriddenValue']));
    }

    public function testAnnotationReaderWithSingleValues() {
        $reader = ReflectionUtils::getAnnotationReader(reflectorTestClass::class, 'annotationTesterOne');

        $this->assertEquals('1', $reader->getParam('testValueInteger'));
        $this->assertEquals('string', $reader->getParam('testValueString'));
        $this->assertTrue($reader->getParam('testValueBool'));
    }

    public function testAnnotationReaderWithJsonValues() {
        $reader = ReflectionUtils::getAnnotationReader(reflectorTestClass::class, 'annotationTesterJson');

        $expectedOne = [
            1, "false", false
        ];

        $expectedTwo = [
            'x' => 5
        ];

        $this->assertEquals($expectedOne, $reader->getParam('testJson'));
        $this->assertEquals($expectedTwo, $reader->getParam('testJsonTwo'));
    }

    public function testAnnotationReaderWithMultipleValue() {
        $reader = ReflectionUtils::getAnnotationReader(reflectorTestClass::class, 'annotationTestMultiVal');

        $expectedArray = ['value', 'value2'];
        $this->assertEquals($expectedArray, $reader->getParam('key'));
    }

    public function testItReturnsTheAllValueAsArray() {
        $reader = ReflectionUtils::getAnnotationReader(reflectorTestClass::class, 'annotationTesterOne');

        $expectedArray = [
            'testValueInteger' => 1,
            'testValueString' => 'string',
            'testValueBool' => TRUE,
        ];

        $this->assertEquals($expectedArray, $reader->getParams());
    }

    public function testAnnotationReaderReturnNullOnNoExistParam() {
        $reader = ReflectionUtils::getAnnotationReader(reflectorTestClass::class, 'annotationTesterOne');

        $this->assertNull($reader->getParam('noExistParam'));
    }

    public function testAnnotationReaderWithClass() {
        $reader = ReflectionUtils::getAnnotationReader(reflectorTestClass::class);

        $this->assertEquals('buildr', $reader->getParam('package'));
    }

}