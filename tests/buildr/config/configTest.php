<?php namespace buildr\tests\config;

use buildr\Config\Config;
use buildr\Config\Facade\Config as ConfigFacade;
use buildr\Config\Source\ConfigSourceInterface;
use buildr\Config\Source\PHPConfigSource;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * BuildR - PHP based continuous integration server
 *
 * Tests for Config class
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Config
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class configTest extends BuildRTestCase {

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The priority must be a number!
     */
    public function testItThrowsExceptionWhenAddingSourceWithInvalidPriority() {
        $source = new PHPConfigSource();

        ConfigFacade::addSource($source, "asd");
        ConfigFacade::addSource($source, NULL);
        ConfigFacade::addSource($source, FALSE);
    }

    /**
     * @expectedException \buildr\Config\Exception\ConfigurationException
     * @expectedExceptionMessage The priority (50) is already taken!
     */
    public function testItThrowsExceptionWhenAddingSourceWithTakenPriority() {
        $source = new PHPConfigSource();

        ConfigFacade::addSource($source, Config::DEFAULT_PRIORITY);
    }

    /**
     * @expectedException \buildr\Config\Exception\ConfigurationException
     * @expectedExceptionMessage Not found any configuration source, registered with name: UNKNOWN_NAME!
     */
    public function testItThrowsExceptionOnUnknownDetectorName() {
        ConfigFacade::getSourceByName("UNKNOWN_NAME");
    }

    /**
     * @expectedException \buildr\Config\Exception\ConfigurationException
     * @expectedExceptionMessage No configuration source exist at priority 2999999!
     */
    public function testItThrowsExceptionOnUnknownDetectorPriority() {
        ConfigFacade::getSourceByPriority(2999999);
    }

    public function testItReturnsTheEnvDetectionConfig() {
        $returnedArray = Config::getEnvDetectionConfig();

        $this->assertArrayHasKey('detector', $returnedArray);
    }

    public function testItReturnsTheProviderConfig() {
        $returnedArray = Config::getProviderConfig();
        $hasProviders = (count($returnedArray) > 0) ? TRUE : FALSE;

        $this->assertTrue($hasProviders);
    }

    public function testItReturnSourceByName() {
        $source = ConfigFacade::getSourceByName(PHPConfigSource::SOURCE_NAME);
        $sourceInstanceOfInterface = ($source instanceof ConfigSourceInterface) ? TRUE : FALSE;

        $this->assertTrue($sourceInstanceOfInterface);
    }

    public function testItReturnsSourceByPriority() {
        $source = ConfigFacade::getSourceByPriority(Config::DEFAULT_PRIORITY);
        $sourceInstanceOfInterface = ($source instanceof ConfigSourceInterface) ? TRUE : FALSE;

        $this->assertTrue($sourceInstanceOfInterface);
    }

    public function testItAddsSourceProperly() {
        $source = new PHPConfigSource();
        ConfigFacade::addSource($source, 10);

        $source = ConfigFacade::getSourceByPriority(10);
        $sourceInstanceOfInterface = ($source instanceof ConfigSourceInterface) ? TRUE : FALSE;

        $this->assertTrue($sourceInstanceOfInterface);
    }

    public function testItReturnsFromAnySource() {
        $result = ConfigFacade::getFormAnySource("main.cache.driver");

        $this->assertNotNull($result);
    }

    public function testItReturnsFromMainSource() {
        $result = ConfigFacade::getFromMainSource("main.cache.driver");

        $this->assertNotNull($result);
    }

    public function testItReturnsFromDefinedSource() {
        $result = ConfigFacade::getFromSource(PHPConfigSource::SOURCE_NAME, "main.cache.driver");

        $this->assertNotNull($result);
    }

    public function testItReturnsDefaultWhenSourceNotFound() {
        $result = ConfigFacade::getFromSource("UNKNOWN_SOURCE", "noFile.noKey", "defaultValue");

        $this->assertEquals("defaultValue", $result);
    }

    public function testItReturnsTheDefaultValueWhenNotFoundOnAnySource() {
        $result = ConfigFacade::getFormAnySource("noFile.noKey", "defaultValue");

        $this->assertEquals("defaultValue", $result);
    }
}