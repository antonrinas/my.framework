<?php

return [
    'routes' => [
        '/test/:id1/:id2/:id3' => [
            'namespace' => 'Application\Controller',
            'controller' => 'TestController',
            'method' => 'index',
            'params' => [
                ':id1' => '(\d+)',
                ':id2' => '(\d+)',
                ':id3' => '(\d+)',
            ],
        ],
        '/test/some-method' => [
            'namespace' => 'Application\Controller',
            'controller' => 'TestController',
            'method' => 'someMethod',
        ]
    ],
];