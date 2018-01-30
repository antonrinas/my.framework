<?php

return [
    'routes' => [
        '/' => [
            'module' => 'Main',
            'namespace' => 'Controller',
            'controller' => 'Index',
            'method' => 'index',
        ],
        '/test/:id1/:id2/:id3' => [
            'module' => 'Main',
            'namespace' => 'Controller',
            'controller' => 'Test',
            'method' => 'index',
            'params' => [
                ':id1' => '(\d+)',
                ':id2' => '(\d+)',
                ':id3' => '(\d+)',
            ],
        ],
        '/test/some-method' => [
            'module' => 'Main',
            'namespace' => 'Controller',
            'controller' => 'Test',
            'method' => 'someMethod',
        ],
    ],
];