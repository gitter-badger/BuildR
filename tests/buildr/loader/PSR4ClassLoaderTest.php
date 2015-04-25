<?php namespace buildr\tests\loader;

use buildr\Loader\PSR4ClassLoader;

/**
 * PSR4ClassLoader tests
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage tests\loader
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class PSR4ClassLoaderTest extends abstractLoaderTestCase {

    protected function setUp() {
        $this->loaderClass = new PSR4ClassLoader();

        parent::setUp();
    }

    public function testItStoreRegisteredNamespaceProperly() {
        $reflector = new \ReflectionClass(get_class($this->loaderClass));

        $this->loaderClass->registerNamespace("myNamespace", "namespaceAbsolutePath");

        $propertyReflector = $reflector->getProperty("registeredNamespaces");
        $propertyReflector->setAccessible(TRUE);
        $registeredNamespaces = $propertyReflector->getValue($this->loaderClass);

        $this->assertCount(1, $registeredNamespaces);
    }
}
