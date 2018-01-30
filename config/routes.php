<?php

return [
    'routes' => [
        '/' => [
            'module' => 'Main',
            'namespace' => 'Controller',
            'controller' => 'IndexController',
            'method' => 'index',
        ],
        '/test/:id1/:id2/:id3' => [
            'module' => 'Main',
            'namespace' => 'Controller',
            'controller' => 'TestController',
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
            'controller' => 'TestController',
            'method' => 'someMethod',
        ],
    ],
];