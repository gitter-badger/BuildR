<?php namespace buildr\tests\environment;

use buildr\Startup\BuildrEnvironment;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * BuildR - PHP based continuous integration server
 *
 * BuildREnvironment tests
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\environment
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class environmentTest extends BuildRTestCase {

    /**
     * @expectedException \buildr\Startup\Environment\Detector\EnvironmentException
     * @expectedExceptionMessage The following detector class (wrongDetector) is not instantiable!
     */
    public function testItThrowsExceptionOnInvalidDetectorClass() {
        $this->invokePrivateMethod(BuildrEnvironment::class, 'getDetectorClosure', ['wrongDetector']);
    }

    /**
     * @expectedException \buildr\Startup\Environment\Detector\EnvironmentException
     * @expectedExceptionMessage The class (\buildr\tests\environment\dummy\DetectorWithNoImplementation) must be implements the DetectorInterface!
     */
    public function testItThrowsExceptionOnNoInterfaceImplementation() {
        $this->invokePrivateMethod(BuildrEnvironment::class, 'getDetectorClosure', ['\buildr\tests\environment\dummy\DetectorWithNoImplementation']);
    }

    /**
     * @expectedException \buildr\Startup\Environment\Detector\EnvironmentException
     * @expectedExceptionMessage The setEnv() function must be take a string as argument!
     */
    public function testItThrowsExceptionOnWrongSetEnv() {
        BuildrEnvironment::setEnv(TRUE);
    }

    public function testItSetsEnvironmentCorrectly() {
        BuildrEnvironment::setEnv("hello");

        $this->assertEquals("hello", BuildrEnvironment::getEnv());
        $this->assertTrue($this->getStaticPropertyFromClass(BuildrEnvironment::class, "isInitialized"));

        BuildrEnvironment::isRunningUnitTests();
    }

    public function testItReturnsNullWhenNotInitialized() {
        $this->setStaticProperty(BuildrEnvironment::class, 'isInitialized', FALSE);

        $this->assertNull(BuildrEnvironment::getEnv());
        BuildrEnvironment::isRunningUnitTests();
    }

    public function testItReturnsTheClosureOnCorrectDetector() {
        $closure = $this->invokePrivateMethod(BuildrEnvironment::class, 'getDetectorClosure', ['\buildr\tests\environment\dummy\DummyDetector']);

        $this->assertInstanceOf('\Closure', $closure);
    }

    public function testItSetsTheEnvironmentToTesting() {

    }

    public function testIsReturnTheDefaultTestingEnvironment() {
        $env = BuildrEnvironment::getEnv();

        $this->assertEquals(BuildrEnvironment::E_TESTING, $env);
    }
}
