<?php

//System-safe absolute path generation
$basePath = realpath(dirname(__DIR__));

$startupLocation = [$basePath, 'src', 'Startup', 'BuildrStartup.php'];
$startupLocation = implode(DIRECTORY_SEPARATOR, $startupLocation);
$startupLocation = realpath($startupLocation);

//Load startup class
require_once $startupLocation;

//Do startup initialization
\buildr\Startup\BuildrStartup::doStartup($basePath);

echo 'Render Time: ' . substr(\buildr\Startup\BuildrStartup::getTimeSinceStartup() * 1000, 0, 4) . 'ms';
