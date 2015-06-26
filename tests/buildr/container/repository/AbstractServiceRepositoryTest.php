<?php namespace buildr\tests\container\repository; 

use buildr\Registry\Exception\ProtectedVariableException;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;
use buildr\tests\container\fixture\dummyClass;

/**
 * Abstract class for service repository tests
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
abstract class AbstractServiceRepositoryTest extends BuildRTestCase {

    /**
     * @type \buildr\Container\Repository\ServiceRepositoryInterface
     */
    private $repository;

    /**
     * @return \buildr\Container\Repository\ServiceRepositoryInterface
     */
    abstract public function setupRepository();

    public function __construct() {
        $this->repository = $this->setupRepository();
    }

    /**
     * @expectedException \buildr\Container\Exception\UndefinedBindingException
     * @expectedExceptionMessage The Container not has the following binding: UndefinedService
     */
    public function testItThrowsExceptionWhenTryToGetUndefinedBinding() {
        $this->repository->get('UndefinedService');
    }

    /**
     * @expectedException \buildr\Container\Exception\ServiceAlreadyRegisteredException
     * @expectedExceptionMessage he following serviceId (test) is already registered!
     */
    public function testItThrowsExceptionWhenTryToAddBindingWithSameName() {
        $this->repository->add('test', new dummyClass());
        $this->repository->add('test', new dummyClass());
    }

    /**
     * @expectedException \buildr\Container\Exception\UndefinedBindingException
     * @expectedExceptionMessage The Container not has the following binding: test
     */
    public function testItThrowsExceptionWhenTryToRemoveUndefinedService() {
        $this->repository->remove('test');
    }

    /**
     * @expectedException \buildr\Container\Exception\ProtectedPropertyException
     * @expectedExceptionMessage The property (test) is already set, and is protected!
     */
    public function testItThrowsExceptionWhenTryToOverrideProtectedProperty() {
        $this->repository->setProperty('test', 'testValue', TRUE);
        $this->repository->setProperty('test', 'modifiedValue');
    }

    public function testHasMethodDetermineTheServiceExistenceCorrectly() {
        $resultFalse = $this->repository->has('test');
        $this->assertFalse($resultFalse);

        $this->repository->add('test', new dummyClass());
        $resultTrue = $this->repository->has('test');
        $this->assertTrue($resultTrue);
    }

    public function testItStoresTheElementsCorrectly() {
        $this->repository->add('test1', new dummyClass());
        $class = $this->getPrivatePropertyFromClass(get_class($this->repository), 'storage', $this->repository);

        $this->assertInstanceOf(dummyClass::class, $class['test1']);
    }

    public function testItRemovesServicesCorrectly() {
        $this->repository->add('test', new dummyClass());
        $content = $this->getPrivatePropertyFromClass(get_class($this->repository), 'storage', $this->repository);

        $this->assertCount(1, $content);

        $this->repository->remove('test');
        $content = $this->getPrivatePropertyFromClass(get_class($this->repository), 'storage', $this->repository);

        $this->assertCount(0, $content);
    }

    public function testItStoresPropertiesCorrectly() {
        $this->repository->setProperty('testUnprotected', 'testValueUnprotected');
        $this->repository->setProperty('testProtected', 'testValueProtected', TRUE);

        $prop = $this->getPrivatePropertyFromClass(get_class($this->repository), 'propertyStorage', $this->repository);

        $this->assertCount(2, $prop);
        $this->assertEquals($prop['testUnprotected']['value'], 'testValueUnprotected');
        $this->assertEquals($prop['testProtected']['value'], 'testValueProtected');

        $this->assertFalse($prop['testUnprotected']['protected']);
        $this->assertTrue($prop['testProtected']['protected']);
    }

    public function testItCanOverrideUnprotectedProperties() {
        $this->repository->setProperty('test', 'testValue');
        $this->repository->setProperty('test', 'modifiedValue');

        $prop = $this->getPrivatePropertyFromClass(get_class($this->repository), 'propertyStorage', $this->repository);

        $this->assertEquals($prop['test']['value'], 'modifiedValue');
    }

    public function testItReturnsTheStoredPropertiesCorrectly() {
        $this->repository->setProperty('test', 'testValue');

        $this->assertEquals('testValue', $this->repository->getProperty('test'));
    }

    public function testItReturnsTheDefaultValueIfThePropertyIsNotDefined() {
        $result = $this->repository->getProperty('test', 'defaultValue');

        $this->assertEquals('defaultValue', $result);
    }

}
