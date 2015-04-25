<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);

//System-safe absolute path generation
$basePath = realpath(dirname(__DIR__));

$startupLocation = [
    $basePath,
    'src',
    'Startup',
    'BuildrStartup.php'
];
$startupLocation = implode(DIRECTORY_SEPARATOR, $startupLocation);
$startupLocation = realpath($startupLocation);

//Load startup class
require_once $startupLocation;

/**
 * Startup Initialization block
 */

//Initialize the autoloader
\buildr\Startup\BuildrStartup::setBasePath($basePath);
\buildr\Startup\BuildrStartup::initializeAutoloading(TRUE);

//Run the initializer
$startup = new \buildr\Startup\BuildrStartup();
$startup->setInitializer(new \buildr\Startup\Initializer\WebInitializer);

echo 'Render Time: ' . substr(\buildr\Startup\BuildrStartup::getTimeSinceStartup() * 1000, 0, 4) . 'ms';
