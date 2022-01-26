<?php
return [
    \App\services\DBService::class => [
        'config' => [
            'driver' => 'mysql',
            'db' => 'tasks_bj',
            'host' => 'localhost',
            'user' => 'root',
            'password' => 'secret',
            'charset' => 'utf8'
        ]
    ]
];