<?php namespace buildr\tests\environment;

use buildr\Startup\BuildrEnvironment;
use buildr\Startup\Environment\Detector\HTTPRequestDomainDetector;
use \buildr\tests\Buildr_TestCase as BuildRTestCase;
use \buildr\Startup\Environment\EnvironmentDetector;

/**
 * BuildR - PHP based continuous integration server
 *
 * EnvironmentDetector tests
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\environment
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class environmentDetectorTest extends BuildRTestCase {

    public function testItsReturnTheCallbackCorrectly() {
        $closure = (function() {
            return TRUE;
        });

        $this->assertTrue($this->invokePrivateMethod(EnvironmentDetector::class, 'detectByCallback', [$closure]));
    }

    public function testItReturnTheConsoleParamsProperty() {
        $arguments = ['--env=developmentTest'];

        $this->assertEquals('developmentTest', $this->invokePrivateMethod(EnvironmentDetector::class, 'detectEnvByConsoleArgs', [$arguments]));
    }

    public function testIsReturnTheCorrectEnvironmentOnWeb() {
        $closure = (function() {
            return 'envClosure';
        });

        $arguments = ['--env=envArg'];

        $detector = new EnvironmentDetector();

        $this->assertEquals('envArg', $detector->detect($closure, $arguments));
        $this->assertEquals('envClosure', $detector->detect($closure));
    }

    public function testItsReturnTheDefaultEnvironmentOnWrongConsoleArgs() {
        $closure = (function() {
            return 'envClosure';
        });

        $arguments = ['-e=a'];

        $detector = new EnvironmentDetector();
        $this->assertEquals(BuildrEnvironment::E_CONSOLE, $detector->detect($closure, $arguments));
    }

    public function testHttpDetector() {
        $_SERVER['HTTP_HOST'] = "test.domain";

        $httpDetector = new HTTPRequestDomainDetector();
        $this->assertEquals('testing', $httpDetector->detect());
    }

    public function testHttpDetectorReturnDevOnNoMatch() {
        $_SERVER['HTTP_HOST'] = "wrong.domain";

        $httpDetector = new HTTPRequestDomainDetector();
        $this->assertEquals(BuildrEnvironment::E_DEV, $httpDetector->detect());
    }

}