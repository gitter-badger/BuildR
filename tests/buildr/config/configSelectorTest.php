<?php namespace buildr\tests\config;

use buildr\Config\Selector\ConfigSelector;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;

class configSelectorTest extends BuildRTestCase {

    public function testValidateProcessingIsProper() {
        $selector = new ConfigSelector("file.my.key");
        $expectedResult = ["my", "key"];

        $this->assertEquals("file", $selector->getFileName());
        $this->assertEquals(DIRECTORY_SEPARATOR . "file.php", $selector->getFilenameForRequire());
        $this->assertEquals($expectedResult, $selector->getSelectorArray());
        $this->assertEquals("file.my.key", $selector->getOriginalSelector());
    }

}