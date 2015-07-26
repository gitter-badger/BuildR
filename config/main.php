<?php

use buildr\Logger\LoggerServiceProvider;
use buildr\Config\ConfigServiceProvider;
use buildr\Filesystem\FilesystemServiceProvider;
use buildr\Cache\CacheServiceProvider;

/**
 * Main configuration file
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
return [

    /**
     * Application Configuration
     */
    'application' => [
        'location' => '/application',
        'namespaceName' => 'buildr\\Application\\'
    ],

    /**
     * Startup configuration
     */
    'startup' => [
        'detector' => 'buildr\Startup\Environment\Detector\HTTPRequestDomainDetector',

        'domains' => [
            'testing' => ['test.domain'],
            //Don't remove. Its used on unit testing
            'production' => ['prod.domain'],
            'development' => ['buildr.zolli.hu'],
        ],
    ],

    /**
     * Cache config
     */
    'cache' => [
        'driver' => 'buildr\Cache\Driver\RuntimeCacheDriver'
    ],

    /**
     * Service Providers
     */
    'serviceProviders' => [
        CacheServiceProvider::class,
        FilesystemServiceProvider::class,
        ConfigServiceProvider::class,
        LoggerServiceProvider::class,
    ],

];
