<?php namespace buildr\tests\serviceProvider;

use buildr\Application\Application;
use buildr\ServiceProvider\ServiceProvider;
use buildr\tests\Buildr_TestCase as BuilderTestCase;

/**
 * ServiceProvider tests
 *
 * BuildR PHP Framework
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

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage This method must take an array as argument!
     */
    public function testItThrowsExceptionWhenTryToRegisterOptionalProvidersByArrayWithNotArrayTypeParameter() {
        ServiceProvider::addOptionalsByArray('InvalidValue');
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage The service name (dummyProvider) is already taken by classFQCN
     */
    public function testItThrowsAnExceptionWhenTryToRegisterOptionalLoaderThatServiceNameIsOccupied() {
        ServiceProvider::addOptionalProvider('dummyProvider', 'classFQCN');
        ServiceProvider::addOptionalProvider('dummyProvider', 'anotherClassFQCN');
    }

    public function testRegistration() {
        $providers = [
            '\buildr\tests\serviceProvider\dummy\dummyProviderOne',
            '\buildr\tests\serviceProvider\dummy\dummyProviderTwo'
        ];

        ServiceProvider::registerProvidersByArray($providers);

        $container = Application::getContainer();

        $this->assertInstanceOf('\stdClass', $container->get('dummyOne'));
        $this->assertInstanceOf('\stdClass', $container->get('dummyTwo'));
    }

    public function testItCanAddOptionalProviders() {
        ServiceProvider::addOptionalsByArray([
            'dummyOne' => '',
            'dummyTwo' => '',
        ]);

        $reflector = new \ReflectionClass(ServiceProvider::class);
        $properties = $reflector->getStaticProperties();

        $this->assertTrue(isset($properties['optionalServices']['dummyOne']));
        $this->assertTrue(isset($properties['optionalServices']['dummyTwo']));
    }

    public function testItDetectsOptionalServicesCorrectly() {
        $this->assertTrue(ServiceProvider::isOptionalService('dummyOne'));
        $this->assertFalse(ServiceProvider::isOptionalService('notRegisteredOptionalService'));
    }

}
