<?php

declare(strict_types=1);

use App\Repositories\ProjectRepository;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Repositories\TaskRepositoryInterface;

return [
    ProjectRepositoryInterface::class => ProjectRepository::class,
    TaskRepositoryInterface::class => TaskRepository::class,
];
