<?php namespace buildr\tests;

use Faker\Factory;

/**
 * Basic testCase for easily unit testing
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Buildr_TestCase extends \PHPUnit_Framework_TestCase {

    /**
     * @var \Faker\Generator
     */
    protected $faker = NULL;

    public function __construct($name = NULL, array $data = [], $dataName = '') {
        $this->faker = Factory::create();

        parent::__construct($name, $data, $dataName);
    }

    /**
     * Get a private property content from class using reflection if the concrete class is provided,
     * reds the property from the concrete class not from a new one
     *
     * @param string $className
     * @param string $propertyName
     * @param null|\stdClass $concreteClass
     *
     * @return mixed
     */
    protected function getPrivatePropertyFromClass($className, $propertyName, $concreteClass = NULL) {
        $reflector = new \ReflectionClass($className);

        $propertyReflector = $reflector->getProperty($propertyName);
        $propertyReflector->setAccessible(TRUE);

        if($concreteClass !== NULL) {
            return $propertyReflector->getValue($concreteClass);
        }

        return $propertyReflector->getValue($reflector->newInstanceWithoutConstructor());
    }

    protected function getStaticPropertyFromClass($className, $propertyName) {
        $reflector = new \ReflectionClass($className);
        $properties = $reflector->getStaticProperties();

        return $properties[$propertyName];
    }

    protected function setStaticProperty($className, $propertyName, $newValue) {
        $reflector = new \ReflectionClass($className);
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(TRUE);

        $property->setValue($reflector->newInstance(), $newValue);
    }

    /**
     * Invoke a private property on a class. If you pass a concrete class the method be called on the concrete,
     * in other case it instantiate a new class without calling the constructor.
     * Call the method and returns the result
     *
     * @param string $className
     * @param string $methodName
     * @param array $methodArguments
     * @param null|\stdClass $concreteClass
     *
     * @return mixed
     */
    protected function invokePrivateMethod($className, $methodName, array $methodArguments = [], $concreteClass = NULL) {
        $reflector = new \ReflectionClass($className);

        $methodReflector = $reflector->getMethod($methodName);
        $methodReflector->setAccessible(TRUE);

        if($concreteClass !== NULL) {
            return $methodReflector->invokeArgs($concreteClass, $methodArguments);
        }

        return $methodReflector->invokeArgs($reflector->newInstanceWithoutConstructor(), $methodArguments);
    }

    /**
     * Return a defined constant from class
     *
     * @param $className
     * @param $constantName
     *
     * @return mixed
     */
    protected function getConstantFromClass($className, $constantName) {
        $reflector = new \ReflectionClass($className);

        return $reflector->getConstant($constantName);
    }

    /**
     * @param string $className
     * @param string $methodName
     *
     * @return \Closure|Callable
     */
    protected function getClosureForMethod($className, $methodName) {
        $classReflector = new \ReflectionClass($className);

        $methodReflector = $classReflector->getMethod($methodName);
        $methodReflector->setAccessible(TRUE);

        return $methodReflector->getClosure($classReflector->newInstanceWithoutConstructor());
    }

    protected function setUp() {

    }

    protected function tearDown() {

    }

}
