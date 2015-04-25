<?php namespace buildr\tests\utils;

use buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * System utilities tests
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Utils
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class systemUtilsTest extends BuildRTestCase {

    public function testProperDetectOsType() {
        $osType = \buildr\Utils\System\SystemUtils::getOsType();

        $cOs = \buildr\Utils\System\SystemUtils::OS_TYPE_NIX;
        if(PHP_OS == "WINNT") {
            $cOs = \buildr\Utils\System\SystemUtils::OS_TYPE_WIN;
        }

        $this->assertEquals($cOs, $osType);
    }

}
