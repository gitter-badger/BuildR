<?php namespace buildr\tests\enumeration;

use \buildr\tests\Buildr_TestCase as BuildRTestCase;
use buildr\tests\enumeration\fixture\testEnumeration;

/**
 * BuildR - PHP based continuous integration server
 *
 * Enumerations tests
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Enumeration
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class enumerationTest extends BuildRTestCase {

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage The enumeration not contains the following constant: TEST_NO_EXIST
     */
    public function testItThrowsExceptionWhenCallANotDefinedConstant() {
        testEnumeration::TEST_NO_EXIST();
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage The key must be a string!
     */
    public function testItThrowsExceptionOnWrongKeyValidation() {
        $this->assertFalse(testEnumeration::isValidKey(false));
    }

    /**
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage The enumeration not contains key like this: TEST_NO_EXIST
     */
    public function testItThrowsExceptionOnConstructWithWrongValue() {
        new testEnumeration('TEST_NO_EXIST');
    }

    public function testItReturnsConstantsAsArray() {
        $expectedArray = ['TEST_ONE' => 'T1', 'TEST_TWO' => 'T2'];

        $this->assertEquals($expectedArray, testEnumeration::toArray());
    }

    public function testItReturnsKeysProperly() {
        $expectedArray = ['TEST_ONE', 'TEST_TWO'];

        $this->assertEquals($expectedArray, testEnumeration::getKeys());
    }

    public function testItValidateKeys() {
        $this->assertTrue(testEnumeration::isValidKey("TEST_ONE"));
        $this->assertFalse(testEnumeration::isValidKey("NO_EXIST_KEY"));
    }

    public function testItFindKeyByValue() {
        $this->assertEquals("TEST_ONE", testEnumeration::find("T1"));
        $this->assertFalse(testEnumeration::find("T_NO_EXIST"));
    }

    public function testItReturnsTheInstance() {
        $this->assertInstanceOf(testEnumeration::class, testEnumeration::TEST_ONE());
    }

    public function testInstanceReturnsValue() {
        $this->assertEquals('T1', testEnumeration::TEST_ONE()->getValue());
    }

    public function testInstanceReturnsKey() {
        $this->assertEquals('TEST_ONE', testEnumeration::TEST_ONE()->getKey());
    }

    public function testInstanceCanValidateValue() {
        $this->assertTrue(testEnumeration::TEST_ONE()->isValid('T1'));
        $this->assertFalse(testEnumeration::TEST_ONE()->isValid('T_NO_EXIST'));
    }

    public function testItReturnsStringOnPrint() {
        ob_clean();
        ob_start();

        echo testEnumeration::TEST_ONE();

        $echoedValue = ob_get_clean();

        $this->assertEquals('T1', $echoedValue);
    }
}
