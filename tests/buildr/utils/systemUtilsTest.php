<?php namespace buildr\tests\utils;

use \buildr\tests\Buildr_TestCase as BuildRTestCase;

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
