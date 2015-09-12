<?php namespace buildr\tests\serviceProvider;

use buildr\Application\Application;
use buildr\ServiceProvider\ServiceProvider;
use buildr\ServiceProvider\ServiceProviderInterface;
use buildr\Container\Alias\AliasResolver;
use buildr\Container\Container;
use buildr\tests\serviceProvider\dummy\dummyProviderOne;
use buildr\tests\serviceProvider\dummy\dummyProviderTwo;
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

    public function notArrayTypeInputProvider() {
        return [
            [NULL],
            ['test'],
            [4],
            [0.14],
            [FALSE],
        ];
    }

    /**
     * @dataProvider notArrayTypeInputProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage This method must take an array as argument!
     */
    public function testItThrowsExceptionWhenTryRegisteringProvidersFromArrayButInputIsNotAnArray($input) {
        ServiceProvider::registerProvidersByArray($input);
    }

    /**
     * @dataProvider notArrayTypeInputProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage This method must take an array as argument!
     */
    public function testItThrowsExceptionWhenTryRegisteringOptionalProvidersFromArrayButInputIsNotAnArray($input) {
        ServiceProvider::addOptionalsByArray($input);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage The service name (testProvider) is already taken by buildr\tests\serviceProvider\dummy\dummyProviderOne
     */
    public function testItThrowsExceptionWhenOptionalServiceProviderNameIsAlreadyRegistered() {
        ServiceProvider::addOptionalProvider('testProvider', dummyProviderOne::class);
        ServiceProvider::addOptionalProvider('testProvider', dummyProviderOne::class);
    }

    public function testItActuallyRegisterBindingsOfOptionalProviders() {
        ServiceProvider::registerOptionalProviderBindings(dummyProviderTwo::class);

        $container = Application::getContainer();
        $resolver = $this->getPrivatePropertyFromClass(Container::class, 'aliasResolver', $container);
        $resolverContains = $this->getPrivatePropertyFromClass(AliasResolver::class, 'aliases', $resolver);

        $isRegistered = isset($resolverContains[ServiceProviderInterface::class]);
        $this->assertTrue($isRegistered);

        //Test it not registered in container
        $this->assertFalse($container->has('dummyTwo'));
        $this->assertFalse($container->has(dummyProviderTwo::class));
    }

    public function testItStoreOptionalServices() {
        ServiceProvider::addOptionalProvider('dummyTwo', dummyProviderTwo::class);

        $this->assertTrue(ServiceProvider::isOptionalService('dummyTwo'));
        $this->assertFalse(ServiceProvider::isOptionalServiceLoaded('dummyTwo'));
    }

}
