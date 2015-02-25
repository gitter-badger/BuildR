<?php

return [

    'detector' => 'buildr\Startup\Environment\Detector\HTTPRequestDomainDetector',

    'domains' => [
        'production' => ['prod.domain'],
        'development' => ['buildr.zolli.hu'],
    ],
];
