<?php namespace buildr\tests\config;

use \buildr\tests\buildr_TestCase as BuildRTestCase;

class configTest extends BuildRTestCase {

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The selector need to be at least 2 parts!
     */
    public function testItThrowsExceptionWithInvalidSelector() {
        \buildr\Config\Config::get("wrongKey");
    }

    public function testIsReturnTheProperValues() {
        $singleValue = \buildr\Config\Config::get("test.testValueSingle");
        $arrayValue = \buildr\Config\Config::get("test.testValueArray");
        $deepValue = \buildr\Config\Config::get("test.testValueDeep.deep.deeper");
        $expectedArrayValue = ['hello', 'world'];

        $this->assertEquals('Hello', $singleValue);
        $this->assertEquals($expectedArrayValue, $arrayValue);
        $this->assertEquals('deepValue', $deepValue);
    }

    /**
     * @expectedException \buildr\Config\Exception\InvalidConfigKeyException
     * @expectedExceptionMessage The following part of the config not found: deper!
     */
    public function testItThrowsTheProperExceptionOnWrongkKeyPart() {
        \buildr\Config\Config::get("test.testValueDeep.deep.deper");
    }

    public function testFileIsAlreadyOnTheCache() {
        $reflector = new \ReflectionClass(\buildr\Config\Config::class);
        $properties = $reflector->getStaticProperties();

        $this->assertArrayHasKey('test', $properties['configCache']);
    }

    public function testConfigKeyGetWithMergeing() {
        \buildr\Config\Config::get("buildr.debug.enabled");
    }

    public function testConfigKeyGetWhenNoEnvironmentalFile() {
        \buildr\Config\Config::get("environment.production");
    }

    public function testEnvironmentDetectionConfigGet() {
        $reflector = new \ReflectionClass(\buildr\Config\Config::class);
        $method = $reflector->getMethod("getEnvDetectionConfig");
        $method->setAccessible(TRUE);
        $result = $method->invoke($reflector->newInstance());

        $this->assertTrue($result);
    }

}