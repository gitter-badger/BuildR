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

//Do additional autoloading
$loader = \buildr\Startup\BuildrStartup::getAutoloader();
$PSR4Loader = $loader->getLoaderByName("PSR4ClassLoader");

$testsPath = realpath($basePath . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'buildr') . DIRECTORY_SEPARATOR;

$PSR4Loader->registerNamespace('buildr\\tests\\', $testsPath);


