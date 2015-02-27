<?php namespace buildr\tests\startup;

use buildr\Loader\ClassLoader;
use buildr\Startup\BuildrStartup;
use buildr\tests\Buildr_TestCase as BuilderTestCase;

/**
 * BuildR - PHP based continuous integration server
 *
 * Startup tests
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\Startup
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class startupTest extends BuilderTestCase {

    public function testItsReturnTheRunningTime() {
        $timeSinceStartup = BuildrStartup::getTimeSinceStartup();
        $result = ($timeSinceStartup > 0 && is_numeric($timeSinceStartup));

        $this->assertTrue($result);
    }

    public function testItReturnsTheAutoloader() {
        $loader = BuildrStartup::getAutoloader();

        $this->assertInstanceOf(ClassLoader::class, $loader);
    }

    public function testItReturnsTheStartupTimeCorrectly() {
        $this->assertTrue(is_float(BuildrStartup::getStartupTime()));
    }

    public function testItReturnsTheBasePath() {
        $this->assertTrue(is_string(BuildrStartup::getBasePath()));
    }

    public function testItSetsTheBasePathCorrectly() {
        $originalBase = BuildrStartup::getBasePath();
        $newPath = "/test/path";

        BuildrStartup::setBasePath($newPath);

        $this->assertEquals($newPath, BuildrStartup::getBasePath());
        BuildrStartup::setBasePath($originalBase);
    }

}