<?php namespace buildr\config\source;

use buildr\Config\Selector\ConfigSelector;
use buildr\tests\config\source\ConfigSourceTestCase;
use buildr\Utils\StringUtils;

/**
 * BuildR - PHP based continuous integration server
 *
 * Test for
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Config\Source
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class PHPConfigSourceTest extends ConfigSourceTestCase {

    /**
     * Return the constructed configuration source
     *
     * @return \buildr\Config\Source\ConfigSourceInterface
     */
    public function getSource() {
        return new PHPConfigSource();
    }

    /**
     * Return the currently tested driver is supporting cache or not
     *
     * @return bool
     */
    public function isCached() {
        return TRUE;
    }


    /**
     * @expectedException \buildr\Config\Exception\ConfigurationException
     * @expectedExceptionMessage The following configuration file Not found: noExistFile.php!
     */
    public function testItThrowsExceptionOnUnknownEnvironmentalFile() {
        $this->invokePrivateMethod(get_class($this->getSource()), "getMainContent", ['noExistFile.php'], $this->getSource());
    }

    /**
     * @expectedException \buildr\Config\Exception\InvalidConfigKeyException
     * @expectedExceptionMessage The following part of the config not found: notExistValue!
     */
    public function testItThrowExceptionOnUnknownSelectorPart() {
        $selector = new ConfigSelector("buildr.debug.notExistValue");
        $this->invokePrivateMethod(get_class($this->getSource()), "getBySelector", [$selector], $this->getSource());
    }

    /**
     * @expectedException \buildr\Config\Exception\ConfigurationException
     */
    public function testItThrowsExceptionOnUnknownFile() {
        $selector = new ConfigSelector("notExistFile.notExistValue");
        $this->invokePrivateMethod(get_class($this->getSource()), "getBySelector", [$selector], $this->getSource());
    }

    public function testIsDetectsPathsCorrectly() {
        $normalPath = $this->getPrivatePropertyFromClass(get_class($this->getSource()), 'sourceFolder', $this->getSource());

        $this->assertTrue(is_string($normalPath));
    }

    public function testItReturnsTheMainConfigCorrectly() {
        $mainConfig = $this->invokePrivateMethod(get_class($this->getSource()), "getMainContent", ['buildr.php'], $this->getSource());

        $this->assertTrue(is_array($mainConfig));
    }

    public function testItReturnsEnvConfigCorrectly() {
        $result = $this->invokePrivateMethod(get_class($this->getSource()), "getEnvContent", ['test.php'], $this->getSource());

        $this->assertTrue(is_array($result));
    }

    public function testItReturnsNullOnUnknownFile() {
        $result = $this->invokePrivateMethod(get_class($this->getSource()), "getEnvContent", ['noExistFile.php'], $this->getSource());

        $this->assertNull($result);
    }

    public function testItReturnsTheCorrectValueBySelector() {
        $selector = new ConfigSelector("main.cache.driver");
        $result = $this->invokePrivateMethod(get_class($this->getSource()), "getBySelector", [$selector], $this->getSource());

        $this->assertNotNull($result);
    }

    public function testItReturnsTheCorrectEnvironmentalValueBySelector() {
        $selector = new ConfigSelector("buildr.debug.enabled");
        $result = $this->invokePrivateMethod(get_class($this->getSource()), "getBySelector", [$selector], $this->getSource());

        $this->assertTrue($result);
    }

}
