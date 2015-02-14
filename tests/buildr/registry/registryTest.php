<?php namespace buildr\tests\registry;

use \buildr\tests\buildr_TestCase as BuildRTestCase;

class registryTest extends BuildRTestCase {

    const TEST_BINDING_NAME = "testClass";
    const TEST_VARIABLE_NAME = "testVariable";

    public function testIsStoreClassesProperly() {
        $classToStore = new \stdClass();

        \buildr\Registry\Registry::bindClass(self::TEST_BINDING_NAME, $classToStore);
        $reflector = new \ReflectionClass(\buildr\Registry\Registry::class);
        $containedClasses = $reflector->getStaticProperties();

        $this->assertInstanceOf("stdClass", $containedClasses["classes"][self::TEST_BINDING_NAME]);
    }

    public function testItReturnsStoredClassCorrectly() {
        $returnedClass = \buildr\Registry\Registry::getClass(self::TEST_BINDING_NAME);

        $this->assertInstanceOf("stdClass", $returnedClass);
    }

    /**
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The registry not has the following binding: wrongBinding!
     */
    public function testItThrowsExceptionOnNotProperBinding() {
        \buildr\Registry\Registry::getClass("wrongBinding");
    }

    public function testItStoreVariablesCorrectly() {
        $toStore = "testValue";

        \buildr\Registry\Registry::setVariable(SELF::TEST_VARIABLE_NAME, $toStore);
        $reflector = new \ReflectionClass(\buildr\Registry\Registry::class);
        $containedVariables = $reflector->getStaticProperties();

        $this->assertEquals($toStore, $containedVariables["variables"][self::TEST_VARIABLE_NAME]);
    }

    public function testItReturnsTheVariableCorrectly() {
        $returnedVariable = \buildr\Registry\Registry::getVariable(self::TEST_VARIABLE_NAME);

        $this->assertEquals("testValue", $returnedVariable);
    }

    /**
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Undefined variable wrongVariable!
     */
    public function testItThrowsProperExceptionOnUndefinedVariable() {
        \buildr\Registry\Registry::getVariable("wrongVariable");
    }

    /**
     * @expectedException        \buildr\Registry\Exception\ProtectedVariableException
     * @expectedExceptionMessage The variable testVariable.protected is already set, and its protected!
     */
    public function testItThrowsExceptionOnProtectedVariableOverride() {
        \buildr\Registry\Registry::setVariable(self::TEST_VARIABLE_NAME . ".protected", "value");
        \buildr\Registry\Registry::setVariable(self::TEST_VARIABLE_NAME . ".protected", "newValue");
    }

}