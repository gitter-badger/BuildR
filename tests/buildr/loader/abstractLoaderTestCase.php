<?php namespace buildr\tests\loader;

use buildr\tests\Buildr_TestCase as BuilderTestCase;

/**
 * BuildR - PHP based continuous integration server
 *
 * Abstract class loader test
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage tests\loader
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class abstractLoaderTestCase extends BuilderTestCase {

    /**
     * @type \buildr\Loader\classLoaderInterface
     */
    protected $loaderClass;

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testItThrowsExceptionOnPrioritySettingWithInvalidValue() {
        $this->loaderClass->setPriority("highPriority");
    }

    public function testItReturnsTheNameProperly() {
        $reflector = new \ReflectionClass(get_class($this->loaderClass));

        $name = $reflector->getConstant('NAME');
        $this->assertEquals($name, $this->loaderClass->getName());
    }

    public function testItReturnsTheDefaultPriority() {
        $reflector = new \ReflectionClass(get_class($this->loaderClass));
        $propertyReflector = $reflector->getProperty("priority");
        $propertyReflector->setAccessible(TRUE);
        $defaultValue = $propertyReflector->getValue($this->loaderClass);

        $this->assertEquals($defaultValue, $this->loaderClass->getPriority());
    }

    public function testItSetsPriorityProperly() {
        $wantedPriority = 100;

        $this->loaderClass->setPriority($wantedPriority);
        $this->assertEquals($wantedPriority, $this->loaderClass->getPriority());
    }
}