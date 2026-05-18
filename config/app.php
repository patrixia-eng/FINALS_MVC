<?php

declare(strict_types=1);

return [
    'name' => 'Task Manager',
    'debug' => filter_var($_ENV['APP_DEBUG'] ?? 'true', FILTER_VALIDATE_BOOLEAN),
    'base_path' => dirname(__DIR__),
    'views_path' => dirname(__DIR__) . '/app/Views',
];
