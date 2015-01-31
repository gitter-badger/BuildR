<?php

class systemUtilsTest extends buildr_TestCase {

    public function testProperDetectOsType() {
        $osType = \buildr\Utils\System\SystemUtils::getOsType();

        $cOs = \buildr\Utils\System\SystemUtils::OS_TYPE_NIX;
        if(PHP_OS == "WINNT") {
            $cOs = \buildr\Utils\System\SystemUtils::OS_TYPE_WIN;
        }

        $this->assertEquals($cOs, $osType);
    }

}
