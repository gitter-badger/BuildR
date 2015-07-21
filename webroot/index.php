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

//Set the base path and initialize the auto-loading classes
\buildr\Startup\BuildrStartup::setBasePath($basePath);
\buildr\Startup\BuildrStartup::initializeAutoloading(TRUE);

//Using the WebInitializer class to initialize the framework
$startup = new \buildr\Startup\BuildrStartup();
$startup->setInitializer(new \buildr\Startup\Initializer\WebInitializer);

//Create the request object
$request = new \buildr\Http\Request\Request();
$request->createFromGlobals($_SERVER, $_COOKIE, $_GET, $_POST, $_FILES);

//Bind request to the container
\buildr\Application\Application::getContainer()->add('request', $request);

//Bind the response
$rsp = new \buildr\Http\Response\Response();
\buildr\Application\Application::getContainer()->add('response', $rsp);

\buildr\Http\Response\Facade\Response::setContentType(new \buildr\Http\Response\ContentType\JsonContentType());
\buildr\Http\Response\Facade\Response::setBody([
    'globals' => $request->getAllGlobal(),
    'headers' => $request->getAllHeaders(),
    'query' => $request->getAllQueryParam(),
    'post' => $request->getAllPostParam(),
    'cookie' => $request->getAllCookie(),
    'startupTime' => (float) substr(\buildr\Startup\BuildrStartup::getTimeSinceStartup() * 1000, 0, 4),
]);

echo \buildr\Http\Response\Facade\Response::send();
