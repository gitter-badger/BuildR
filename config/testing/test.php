<?php

/**
 * Configuration file for unit testing
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

    'testValueSingle' => 'Hello',
    'testValueArray' => [
        'hello',
        'world'
    ],
    'testValueDeep' => [
        'deep' => [
            'deeper' => 'deepValue',
        ],
    ],

];
