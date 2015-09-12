<?php namespace buildr\tests\container;

use buildr\Application\Application;
use buildr\Container\Container;
use buildr\Container\ContainerInterface;
use buildr\tests\container\fixture\dummyClass;
use buildr\tests\container\fixture\Car;
use buildr\tests\container\fixture\SelfDependentEngine;
use buildr\tests\container\fixture\RacingEngine;
use buildr\tests\container\fixture\DieselEngine;
use buildr\tests\container\fixture\ElectricEngine;
use buildr\tests\container\fixture\WireCar;
use buildr\tests\container\fixture\InjuredWireCar;
use buildr\tests\container\fixture\AbstractEngine;
use buildr\tests\container\fixture\ManualTransmission;
use buildr\tests\container\fixture\EngineInterface;
use buildr\tests\container\fixture\TransmissionInterface;
use buildr\Container\ContextualBuilder;
use buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Container tests
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Container\Repository
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ContainerTest extends BuildRTestCase {

    /**
     * @type \buildr\Container\ContainerInterface
     */
    protected $container;

    public function setUp() {
        $this->container = Application::getContainer();
    }

    /**
     * @expectedException \buildr\Container\Exception\InstantiationException
     * @expectedExceptionMessage Cant instantiate abstract classes! (buildr\tests\container\fixture\AbstractEngine)
     */
    public function testItThrowsExceptionWhenTryToInstantiateAnAbstractClass() {
        $container = new Container();

        $container->bind(EngineInterface::class, AbstractEngine::class);
        $container->bind(TransmissionInterface::class, ManualTransmission::class);

        $container->get(Car::class);
    }

    /**
     * @expectedException \buildr\Container\Exception\NotFoundException
     * @expectedExceptionMessage The entry (\Foo\Bar) is not bound, and cant create it automatically!
     */
    public function testItThrowsExceptionWhenTryingToGetClassThatNotExist() {
        $container = new Container();

        $container->get('\Foo\Bar');
    }

    /**
     * @expectedException \buildr\Container\Exception\NotFoundException
     * @expectedExceptionMessage The following entry not bound to container: undefinedBinding
     */
    public function testExtendingThrowsExceptionWhenTheClassIsNotBinded() {
        $container = new Container();

        $container->extend('undefinedBinding', function(ContainerInterface $c) {});
    }

    /**
     * @expectedException \buildr\Container\Exception\InjectionException
     * @expectedExceptionMessage Unable to automatically inject class property (buildr\tests\container\fixture\InjuredWireCar::engine). No value specified!
     */
    public function testInjectionThrowExceptionWhenNoCLassNameSpecified() {
        $container = new Container();

        $container->wire(InjuredWireCar::class);
        $container[InjuredWireCar::class];
    }

    public function testItInjectPropertiesFromPreDefinedArray() {
        $container = new Container();

        $injuredWireCar = new InjuredWireCar();
        $container->inject($injuredWireCar, [
            'engine' => (new RacingEngine()),
        ]);

        $this->assertInstanceOf(RacingEngine::class, $injuredWireCar->engine);
    }

    public function testItStoreOwnInstanceCorrectly() {
        $container = new Container();

        $this->assertTrue(($container->get('container') instanceof ContainerInterface));
        $this->assertTrue(($container->get(ContainerInterface::class) instanceof ContainerInterface));
    }

    public function testClosureBinding() {
        $container = new Container();

        $container->closure('testBinding', function(ContainerInterface $c) {
             return new DieselEngine();
        });

        $result = $container->get('testBinding');

        $this->assertInstanceOf(DieselEngine::class, $result);

        //Returns the same instance
        $anotherResult = $container['testBinding'];

        $this->assertTrue($result === $anotherResult);
    }

    public function testItStoreAndResolvesAliasesCorrectly() {
        $container = new Container();

        $container->alias('hello', 'world');
        $resolver = $this->getPrivatePropertyFromClass(Container::class, 'aliasResolver', $container);

        $origin = $resolver->getOrigin('hello');

        $this->assertEquals('world', $origin);

        //Test that returns the original input when is not an alias
        $undefinedAliasResult = $resolver->getOrigin('helloWorld');
        $this->assertEquals('helloWorld', $undefinedAliasResult);
    }

    public function testAutoWireWorksCorrectly() {
        $container = new Container();

        $container->bind(EngineInterface::class, DieselEngine::class);
        $container->wire(WireCar::class);

        $result = $container[WireCar::class];

        $this->assertInstanceOf(DieselEngine::class, $result->engine);
        $this->assertInstanceOf(ManualTransmission::class, $result->transmission);
        $this->assertInstanceOf(WireCar::class, $result);
    }

    public function testItDestroysObjectsCorrectly() {
        $container = new Container();

        $container['test'] = new \stdClass();
        $container['testUntouched'] = new \stdClass();

        $container['test'];

        $container->destroy('testUntouched');

        $this->setExpectedException('\buildr\Container\Exception\CannotChangeException',
            'Cannot destroy object that been frozen! (test)');

        //Also tests offsetUnset() method
        unset($container['test']);
    }

    public function testBindingExtension() {
        $container = new Container();

        //Instance extension

        $container->bind(EngineInterface::class, DieselEngine::class);
        $container->wire(WireCar::class);
        $container[WireCar::class];

        $container->extend(WireCar::class, function(WireCar $car) {
            $car->engine = new RacingEngine();

            return $car;
        });

        $car = $container[WireCar::class];

        $this->assertInstanceOf(RacingEngine::class, $car->engine);

        //Closure extension

        $container->closure('engine', function(ContainerInterface $c) {
            return new DieselEngine();
        });

        $container->extend('engine', function(DieselEngine $engine) {
            $engine->sound = 'test';

            return $engine;
        });

        $engine = $container['engine'];

        $this->assertInstanceOf(DieselEngine::class, $engine);
        $this->assertEquals('test', $engine->getSound());
    }

    public function testHasWorksCorrectly() {
        $container = new Container();

        $container['testBinding'] = new \stdClass();

        $this->assertTrue($container->has('testBinding'));
        $this->assertFalse(isset($container['undefinedBinding']));
    }

    public function testIfAnInstanceIsRegisteredAlwaysReturnTheSameInstance() {
        $container = new Container();
        $engine = new RacingEngine();

        $container->instance('test', $engine);
        $result = $container->get('test');

        $this->assertInstanceOf(RacingEngine::class, $result);
        $this->assertSame($engine, $result);
        $this->assertTrue($engine === $result);
    }

    public function testItCreatesAndResolvesContextualBindingCorrectly() {
        $container = new Container();
        $binder = $container->when('Foo\Bar');

        //Test that is returned the correct contextual binder class
        $this->assertInstanceOf(ContextualBuilder::class, $binder);

        $binder->needs('Foo\Bar\BarInterface')->give('Foo\Bar\BarImplementation');

        $this->setPropertyOnObject($container, 'buildStack', ['Foo\Bar']);
        $res = $this->invokePrivateMethod(get_class($container),
            'getContextualConcrete',
            ['Foo\Bar\BarInterface'],
            $container);

        //Test the actual contextual resolution
        $this->assertEquals('Foo\Bar\BarImplementation', $res);
    }

    public function testGettingNotBoundedServices() {
        $container = new Container();

        $container->bind(Car::class);
        $container->when(Car::class)->needs(TransmissionInterface::class)->give(ManualTransmission::class);
        $container->bind(EngineInterface::class, RacingEngine::class);

        $car = $container->get(Car::class);

        $this->assertInstanceOf(Car::class, $car);
        $this->assertInstanceOf(TransmissionInterface::class, $car->transmission);
        $this->assertInstanceOf(EngineInterface::class, $car->engine);
    }

    public function testItResolvesTheMethodDependenciesFromGivenDefaultsAndNulls() {
        $container = new Container();

        $injuredWireCar = new InjuredWireCar();
        $reflector = new \ReflectionObject($injuredWireCar);
        $method = $reflector->getMethod('testMethod');

        $result = $this->invokePrivateMethod(Container::class, 'resolveClassDependencies', [$method, [
            'depOne' => 'hello',
        ]], $container);

        $expectedResult = [
            'hello',
            NULL,
        ];

        $this->assertCount(2, $result);
        $this->assertEquals($expectedResult, $result);
    }

}
