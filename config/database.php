<?php

declare(strict_types=1);

return [
    'driver' => $_ENV['DB_DRIVER'] ?? 'sqlite',
    'sqlite' => [
        'path' => dirname(__DIR__) . '/database/taskmanager.sqlite',
    ],
    'mysql' => [
        'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
        'port' => (int) ($_ENV['DB_PORT'] ?? 3306),
        'database' => $_ENV['DB_DATABASE'] ?? 'taskmanager',
        'username' => $_ENV['DB_USERNAME'] ?? 'root',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
        'charset' => 'utf8mb4',
    ],
];
