<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

//System-safe absolute path generation
$basePath = realpath(dirname(__DIR__));

$startupLocation = [$basePath, 'src', 'Startup', 'BuildrStartup.php'];
$startupLocation = implode(DIRECTORY_SEPARATOR, $startupLocation);
$startupLocation = realpath($startupLocation);

//Load startup class
require_once $startupLocation;

//Do startup initialization
\buildr\Startup\BuildrStartup::doStartup($basePath);
