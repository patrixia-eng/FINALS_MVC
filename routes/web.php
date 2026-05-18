<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\ProjectController;
use App\Controllers\TaskController;

/** @var Core\Application $app */
$router = $app->router();

// Home
$router->get('/', [HomeController::class, 'index']);

// Projects CRUD

$router->get('/projects', [ProjectController::class, 'index']);
$router->get('/projects/create', [ProjectController::class, 'create']);
$router->post('/projects', [ProjectController::class, 'store']);
$router->get('/projects/{id}', [ProjectController::class, 'show']);
$router->get('/projects/{id}/edit', [ProjectController::class, 'edit']);
$router->post('/projects/{id}', [ProjectController::class, 'update']);
$router->post('/projects/{id}/delete', [ProjectController::class, 'destroy']);

// Tasks CRUD
$router->get('/tasks', [TaskController::class, 'index']);
$router->get('/tasks/create', [TaskController::class, 'create']);
$router->post('/tasks', [TaskController::class, 'store']);
$router->get('/tasks/{id}/edit', [TaskController::class, 'edit']);
$router->post('/tasks/{id}', [TaskController::class, 'update']);
$router->post('/tasks/{id}/delete', [TaskController::class, 'destroy']);
