<?php namespace buildr\Application;

use buildr\Config\Config;
use buildr\Container\ContainerInterface;
use buildr\Loader\PSR4ClassLoader;
use buildr\Startup\BuildrStartup;

/**
 * Main application constructor
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Application
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class Application {

    /**
     * @type \buildr\Container\ContainerInterface
     */
    private static $container;

    /**
     * @type string
     */
    private $appNamespacePrefix;

    /**
     * Initialize
     */
    public function initialize($config) {
        //Get the autoloader and basePath
        $autoloader = BuildrStartup::getAutoloader();
        $basePath = BuildrStartup::getBasePath();

        //Get the class loader and register tha application namespace
        /**
         * @var \buildr\Loader\PSR4ClassLoader $loader
         */
        $loader = $autoloader->getLoaderByName(PSR4ClassLoader::NAME)[0];

        $appAbsolute = realpath($basePath . $config['location']) . DIRECTORY_SEPARATOR;
        $loader->registerNamespace($config['namespaceName'], $appAbsolute);

        //Create a constant with application namespace prefix
        define('APP_NS', $config['namespaceName']);
    }

    /**
     * Run the application from the defined namespace root.
     *
     * @param string $namespace
     *
     * @return \buildr\Http\Response\ResponseInterface|NULL
     */
    public function run($namespace) {
        $this->appNamespacePrefix = $namespace;

        //Initialize the routing. In this phase run the loading of all defined routes
        $router = $this->initializeRouting();

        //Run the router loop
        $router->run();

        return $router->getResponse();
    }

    /**
     * Run the router initialization, and execute
     * the routing registration.
     *
     * @return \buildr\Router\RouterInterface
     */
    private function initializeRouting() {
        $applicationRouterClass = $this->appNamespacePrefix . 'Core\Http\Routing';

        try {
            /**
             * @var \buildr\Contract\Application\ApplicationRoutingContract $class
             */
            $routeRegistry = new $applicationRouterClass;
        } catch(\Exception $e) {

        }

        /**
         * @var \buildr\Router\RouterInterface $router;
         */
        $router = self::getContainer()->get('router');

        $routeRegistry->register($router);

        return $router;
    }

    /**
     * Set the container instance on the application
     *
     * @param \buildr\Container\ContainerInterface $c
     */
    public static function setContainer(ContainerInterface $c) {
        self::$container = $c;
    }

    /**
     * Get the DI container for application
     *
     * @return \buildr\Container\ContainerInterface
     */
    public static function getContainer() {
        return self::$container;
    }

}
