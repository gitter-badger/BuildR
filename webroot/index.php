<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

//System-safe absolute path generation
$basePath = realpath('..');

$startupLocation = [$basePath, 'src', 'Startup', 'buildrStartup.php'];
$startupLocation = implode(DIRECTORY_SEPARATOR, $startupLocation);
$startupLocation = realpath($startupLocation);

//Load startup class
require_once $startupLocation;

//Do startup initialization
\buildr\Startup\buildrStartup::doStartup($basePath);

d(\buildr\Startup\buildrStartup::getTimeSinceStartup());