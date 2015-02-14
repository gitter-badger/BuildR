<?php namespace buildr\tests\serviceProvider;

use buildr\ServiceProvider\ServiceProvider;
use buildr\tests\Buildr_TestCase as BuilderTestCase;

/**
 * BuildR - PHP based continuous integration server
 *
 * Serviceprovider tests
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage tests\serviceProvider
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class serviceProviderTest extends BuilderTestCase {

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage This method must take an array as argument!
     */
    public function testItThrowExceptionOnMassRegistration() {
        ServiceProvider::registerProvidersByArray("testClassName");
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage The provider class (testProvider) not found!
     */
    public function testItThrowsExceptionOnUnknownProvider() {
        $classReflector = new \ReflectionClass('\buildr\ServiceProvider\ServiceProvider');
        $method = $classReflector->getMethod("checkProviderByName");
        $method->setAccessible(TRUE);

        $method->invokeArgs($classReflector->newInstanceWithoutConstructor(), ['testProvider']);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Provider (\buildr\tests\serviceProvider\dummy\dummyProviderWithoutSubclass) must be implement ServiceProviderInterface!
     */
    public function testItThrowsExceptionWhenClassIsNotSubclass() {
        $classReflector = new \ReflectionClass('\buildr\ServiceProvider\ServiceProvider');
        $method = $classReflector->getMethod("checkProviderByName");
        $method->setAccessible(TRUE);

        $method->invokeArgs($classReflector->newInstanceWithoutConstructor(), ['\buildr\tests\serviceProvider\dummy\dummyProviderWithoutSubclass']);
    }

}