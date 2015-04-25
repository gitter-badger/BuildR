<?php namespace buildr\tests\config\source;

use buildr\Config\Selector\ConfigSelector;
use buildr\Startup\BuildrEnvironment;
use buildr\tests\Buildr_TestCase;

/**
 * Abstract test for various config sources
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage tests\Config\Source
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
abstract class ConfigSourceTestCase extends Buildr_TestCase {

    /**
     * Return the constructed configuration source
     *
     * @return \buildr\Config\Source\ConfigSourceInterface
     */
    abstract public function getSource();

    /**
     * Return the currently tested driver is supporting cache or not
     *
     * @return bool
     */
    abstract public function isCached();

    public function testItReturnsTheDefaultValueWhenUnknownFileBySelector() {
        $result = $this->getSource()->get(new ConfigSelector("notExistFile.notExistValue"), "expectedDefault");

        $this->assertEquals("expectedDefault", $result);
    }

    public function testItReturnsTheDefaultValueWhenUnknownConfigKey() {
        $result = $this->getSource()->get(new ConfigSelector("buildr.notExistValue"), "expectedDefault");

        $this->assertEquals("expectedDefault", $result);
    }

    public function testItReturnsNameCorrectly() {
        $actualName = $this->getConstantFromClass(get_class($this->getSource()), 'SOURCE_NAME');

        $this->assertEquals($actualName, $this->getSource()->getName());
    }

    public function testItReturnsTheEnvironmentCorrectly() {
        $currentEnv = BuildrEnvironment::getEnv();
        $this->assertEquals($currentEnv, $this->getSource()->getEnvironmentName());
    }

    public function testGetReturnsTheCorrectValue() {
        $result = $this->getSource()->get(new ConfigSelector("main.cache.driver"));
        $this->assertNotNull($result);
    }

    public function testItHitTheCache() {
        if($this->isCached()) {
            $result = $this->getSource()->get(new ConfigSelector("main.cache.driver"));

            $this->assertNotNull($result);

            return;
        }

        $this->assertTrue(TRUE);
    }

}
