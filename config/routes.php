<?php

return [
    'routes' => [
        [
            'url' => '/',
            'request_method' => 'GET',
            'module' => 'Main',
            'namespace' => 'Controller',
            'controller' => 'Index',
            'method' => 'index',
        ],
        [
            'url' => '/test/:id1/:id2/:id3',
            'request_method' => 'GET',
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
        [
            'url' => '/test/some-method',
            'request_method' => 'GET',
            'module' => 'Main',
            'namespace' => 'Controller',
            'controller' => 'Test',
            'method' => 'someMethod',
        ],

        /**
         * API
         */
        [
            'url' => '/api/tasks',
            'request_method' => 'GET',
            'module' => 'Api',
            'namespace' => 'Controller',
            'controller' => 'Task',
            'method' => 'index',
        ],
        [
            'url' => '/api/tasks',
            'request_method' => 'POST',
            'module' => 'Api',
            'namespace' => 'Controller',
            'controller' => 'Task',
            'method' => 'store',
        ],
        [
            'url' => '/api/tasks/:id/edit',
            'request_method' => 'GET',
            'module' => 'Api',
            'namespace' => 'Controller',
            'controller' => 'Task',
            'method' => 'edit',
            'params' => [
                ':id' => '(\d+)',
            ],
        ],
        [
            'url' => '/api/tasks/:id',
            'request_method' => 'PUT',
            'module' => 'Api',
            'namespace' => 'Controller',
            'controller' => 'Task',
            'method' => 'update',
            'params' => [
                ':id' => '(\d+)',
            ],
        ],
        [
            'url' => '/api/tasks/:id',
            'request_method' => 'DELETE',
            'module' => 'Api',
            'namespace' => 'Controller',
            'controller' => 'Task',
            'method' => 'destroy',
            'params' => [
                ':id' => '(\d+)',
            ],
        ],
    ],
];