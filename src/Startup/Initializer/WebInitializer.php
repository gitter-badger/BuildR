<?php namespace buildr\Startup\Initializer;

use \buildr\Config\Config;
use buildr\Container\Facade\Buildr;
use buildr\Loader\classLoader;
use buildr\Loader\PSR4ClassLoader;
use buildr\Startup\BuildrEnvironment;
use buildr\Http\Request\RequestServiceProvider;
use buildr\Http\Response\ResponseServiceProvider;
use buildr\Router\RouterServiceProvider;
use buildr\Application\ApplicationServiceProvider;
use Patchwork\Utf8\Bootup;

/**
 * Initializer class for web requests
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Startup\Initializer
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 *
 * @codeCoverageIgnore
 */
class WebInitializer extends BaseInitializer {

    /**
     * Run the startup initialization process
     *
     * @param string $basePath
     * @param \buildr\Loader\classLoader $autoloader
     *
     * @return bool
     */
    public function initialize($basePath, classLoader $autoloader) {
        //Initialize Patchwork-UTF8 mbstring library
        Bootup::initMbstring();

        //Environment detection
        BuildrEnvironment::detectEnvironment();
        $environment = BuildrEnvironment::getEnv();

        //Set up the environment in the registry
        Buildr::add('property.environment', $environment);

        //Get the main application settings
        $config = Config::getMainConfig();

        //Get the class loader and register tha application namespace
        /**
         * @var \buildr\Loader\PSR4ClassLoader $loader
         */
        $loader = $autoloader->getLoaderByName(PSR4ClassLoader::NAME)[0];

        $appAbsolute = realpath($basePath . $config['application']['location']) . DIRECTORY_SEPARATOR;
        $loader->registerNamespace($config['application']['namespaceName'], $appAbsolute);

        //Create a constant with application namespace prefix
        define('APP_NS', $config['application']['namespaceName']);

        //Register additional providers, that exist only in web requests
        $this
            ->addProvider(RequestServiceProvider::class)
            ->addProvider(ResponseServiceProvider::class)
            ->addProvider(RouterServiceProvider::class)
            ->addProvider(ApplicationServiceProvider::class);

        parent::initialize($basePath, $autoloader);
    }
}
