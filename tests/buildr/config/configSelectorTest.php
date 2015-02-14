<?php namespace buildr\tests\config;

use \buildr\tests\buildr_TestCase as BuildRTestCase;

class configSelectorTest extends BuildRTestCase {

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The selector need to be at least 2 parts!
     */
    public function testItThrowsExceptionOnWrongKey() {
        new \buildr\Config\Selector\ConfigSelector("wrongKey");
    }

    public function testValidateProcessingIsProper() {
        $selector = new \buildr\Config\Selector\ConfigSelector("file.my.key");
        $expectedResult = ["my", "key"];

        $this->assertEquals("file", $selector->getFileName());
        $this->assertEquals(DIRECTORY_SEPARATOR . "file.php", $selector->getFilenameForRequire());
        $this->assertEquals($expectedResult, $selector->getSelectorArray());
        $this->assertEquals("file.my.key", $selector->getOriginalSelector());
    }

}