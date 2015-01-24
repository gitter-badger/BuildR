<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$basePath = realpath('.');

//System-safe absolute path generation
$startupLocation = [$basePath, 'src', 'Startup', 'buildrStartup.php'];
$startupLocation = implode(DIRECTORY_SEPARATOR, $startupLocation);
$startupLocation = realpath($startupLocation);

//Load startup class
require_once $startupLocation;

//Do startup initialization
\buildr\Startup\buildrStartup::initializeAutoloading($basePath, TRUE);