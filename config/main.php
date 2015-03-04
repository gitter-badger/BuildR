<?php

return [
    /**
     * Startup configuration
     */
    'startup' => [
        'detector' => 'buildr\Startup\Environment\Detector\HTTPRequestDomainDetector',

        'domains' => [
            'testing' => ['test.domain'],           //Don't remove. Its used on unit testing
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
        'buildr\Cache\CacheServiceProvider',
        'buildr\Filesystem\FilesystemServiceProvider',
        'buildr\Config\ConfigServiceProvider',
        'buildr\Logger\LoggerServiceProvider',
    ],
];
