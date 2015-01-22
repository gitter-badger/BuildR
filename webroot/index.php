<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

//System-safe absolute path generation
$classLoaderLocation = ['..', 'src', 'Loader', 'classLoader.php'];
$classLoaderLocation = implode(DIRECTORY_SEPARATOR, $classLoaderLocation);
$classLoaderLocation = realpath($classLoaderLocation);

//Load classLoader
require_once $classLoaderLocation;

//Initialize and set-up autoloading
\buildr\Loader\classLoader::loadAutoLoader();
$loader = new \buildr\Loader\classLoader();

$PSR4Loader = new \buildr\Loader\PSR4ClassLoader();
$sourceAbsolute = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src') . DIRECTORY_SEPARATOR;
$PSR4Loader->registerNamespace('buildr\\', $sourceAbsolute);

$loader->registerLoader($PSR4Loader);
$loader->initialize();

//Do startup initialization
\buildr\Startup\buildrStartup::doStartup();