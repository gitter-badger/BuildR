<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$basePath = realpath(dirname(__DIR__));

//System-safe absolute path generation
$startupLocation = [$basePath, 'src', 'Startup', 'BuildrStartup.php'];
$startupLocation = implode(DIRECTORY_SEPARATOR, $startupLocation);
$startupLocation = realpath($startupLocation);

//Load startup class
require_once $startupLocation;

//Do startup initialization and set environment to testing
\buildr\Startup\BuildrStartup::initializeAutoloading($basePath, TRUE);
buildr\Startup\BuildrEnvironment::setEnv(\buildr\Startup\BuildrEnvironment::E_TESTING);

//Loading base test class
$testCasePath = realpath("./tests/buildr/Buildr_TestCase.php");

require_once $testCasePath;
