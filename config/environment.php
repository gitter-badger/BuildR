<?php

return [

    'detector' => 'buildr\Startup\Environment\Detector\HTTPRequestDomainDetector',

    'domains' => [
        'testing' => ['test.domain'],           //Don't remove. Its used on unit testing
        'production' => ['prod.domain'],
        'development' => ['buildr.zolli.hu'],
    ],
];
