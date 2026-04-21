<?php

declare(strict_types=1);

return [
    'default' => 'mysql',
    'mysql' => [
        'type' => 'mysql',
        'host' => 'MySQL-8.4',
        'port' => '3306',
        'database' => 'tt_todolist',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
    ],
    'sqlite' => [
        'type' => 'sqlite',
        'path' => __DIR__ . '/../database/database.sqlite',
    ],
];
