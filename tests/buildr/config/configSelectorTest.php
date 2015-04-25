<?php namespace buildr\tests\config;

use buildr\Config\Selector\ConfigSelector;
use buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Config selector tests
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Config
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class configSelectorTest extends BuildRTestCase {

    public function testValidateProcessingIsProper() {
        $selector = new ConfigSelector("file.my.key");
        $expectedResult = [
            "my",
            "key"
        ];

        $this->assertEquals("file", $selector->getFileName());
        $this->assertEquals(DIRECTORY_SEPARATOR . "file.php", $selector->getFilenameForRequire());
        $this->assertEquals($expectedResult, $selector->getSelectorArray());
        $this->assertEquals("file.my.key", $selector->getOriginalSelector());
    }

}