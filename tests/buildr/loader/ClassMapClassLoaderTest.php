<?php namespace buildr\tests\loader;

use buildr\Loader\ClassMapClassLoader;

/**
 * BuildR - PHP based continuous integration server
 *
 * ClassMapClassLoader tests
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage tests\loader
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ClassMapClassLoaderTest extends abstractLoaderTestCase {

    protected function setUp() {
        $this->loaderClass = new ClassMapClassLoader();

        parent::setUp();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The class map must be an array!
     */
    public function testItThrowsExceptionOnWrongClassmap() {
        $this->loaderClass->registerClassMap("wrongClassMap");
    }

    public function testItLoadRegisteredFilesProperly() {
        $this->loaderClass->registerFile(__DIR__ . DIRECTORY_SEPARATOR . "dummy" . DIRECTORY_SEPARATOR . "dummyClass.php");
        $this->invokePrivateMethod(get_class($this->loaderClass), "preLoadRegisteredFiles", [], $this->loaderClass);

        $this->assertTrue(function_exists("sayHello"));
    }

    public function testItStoreRegisteredClassMapProperly() {
        $this->loaderClass->registerClassMap(["my" => "map"]);
        $value = $this->getPrivatePropertyFromClass(get_class($this->loaderClass), "registeredClassMap", $this->loaderClass);

        $this->assertCount(1, $value);
    }

    public function testItStoreRegisteredFilesCorrectly() {
        $this->loaderClass->registerFile("myFile.php");
        $value = $this->getPrivatePropertyFromClass(get_class($this->loaderClass), "registeredFiles", $this->loaderClass);

        $this->assertEquals("myFile.php", $value[0]);
    }
}
