<?php namespace buildr\tests\container;

use buildr\Application\Application;
use buildr\tests\container\fixture\dummyClass;
use buildr\tests\container\fixture\Car;
use buildr\tests\container\fixture\SelfDependentEngine;
use buildr\tests\container\fixture\RacingEngine;
use buildr\tests\container\fixture\DieselEngine;
use buildr\tests\container\fixture\ElectricEngine;
use buildr\tests\container\fixture\AbstractEngine;
use buildr\tests\container\fixture\ManualTransmission;
use buildr\tests\container\fixture\EngineInterface;
use buildr\tests\container\fixture\TransmissionInterface;
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
     * @type \buildr\Container\Container
     */
    private $container;

    protected function setUp() {
        $this->container = Application::getContainer();

        parent::setUp();
    }

    /**
     * @expectedException \buildr\Container\Exception\InstantiationException
     * @expectedExceptionMessage Unable to instantiate class (buildr\tests\container\fixture\SelfDependentEngine)! Circular dependency detected: buildr\tests\container\fixture\SelfDependentEngine => buildr\tests\container\fixture\SelfDependentEngine
     */
    public function testItThrowsExceptionWhenDetectsCircularDependency() {
        $this->container->construct(SelfDependentEngine::class);
    }

    /**
     * @expectedException \buildr\Container\Exception\AbstractionException
     * @expectedExceptionMessage Unable to bind not abstract class!
     */
    public function testItThrowsExceptionWhenTryToBindConcreteClasses() {
        $this->container->bind(RacingEngine::class, DieselEngine::class);
    }

    /**
     * @expectedException \buildr\Container\Exception\AbstractionException
     * @expectedExceptionMessage Cant instantiate abstract classes!
     */
    public function testItThrowsExceptionWhenTryToResolveAnAbstractClass() {
        $this->container->construct(AbstractEngine::class);
    }

    public function testCanResolveClassWithNoDependency() {
        $class = $this->container->construct(dummyClass::class);
        $class2 = $this->container->construct(dummyClass::class);

        //The two resolved object are separate instance
        $this->assertFalse($class === $class2);

        //Resolved the correct type
        $this->assertInstanceOf(dummyClass::class, $class);
        $this->assertInstanceOf(dummyClass::class, $class2);
    }

    public function testCanCreateSingletonInstances() {
        $class = $this->container->singleton(dummyClass::class);
        $class2 = $this->container->singleton(dummyClass::class);

        //The two resolved object are same instance
        $this->assertTrue($class === $class2);

        //Resolved the correct type
        $this->assertInstanceOf(dummyClass::class, $class);
        $this->assertInstanceOf(dummyClass::class, $class2);
    }

    public function testCanResolveClassUsingSharedResources() {
        //Binding a shared resource
        $class = $this->container->singleton(dummyClass::class);

        //Force container to use shared resources if available
        $class2 = $this->container->construct(dummyClass::class, TRUE);

        //The two resolved object are same instance
        $this->assertTrue($class === $class2);

        //Resolved the correct type
        $this->assertInstanceOf(dummyClass::class, $class);
        $this->assertInstanceOf(dummyClass::class, $class2);
    }

    public function testCanResolveClassWithoutConstructor() {
        $class = $this->container->construct(RacingEngine::class);

        $this->assertInstanceOf(RacingEngine::class, $class);
    }

    public function testCanResolveClassWithConstructorDefaultValue() {
        $class = $this->container->construct(DieselEngine::class);

        $this->assertInstanceOf(DieselEngine::class, $class);
        $this->assertEquals('VrrRrrr', $class->getSound());
    }

    public function testItResolveClassWithInterfaceBindings() {
        $this->container->bind(TransmissionInterface::class, ManualTransmission::class);
        $this->container->bind(EngineInterface::class, ElectricEngine::class);

        $class = $this->container->construct(Car::class);

        $this->assertInstanceOf(Car::class, $class);
    }


}
