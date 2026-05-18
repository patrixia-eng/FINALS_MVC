<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Task;
use Core\Database\Connection;

class TaskRepository implements TaskRepositoryInterface
{
    private Task $model;

    public function __construct(Connection $connection)
    {
        $this->model = new Task($connection);
    }

    public function all(): array
    {
        return $this->model->all();
    }

    public function find(int $id): ?array
    {
        return $this->model->find($id);
    }

    public function create(array $data): int
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->model->delete($id);
    }

    public function forProject(int $projectId): array
    {
        return $this->model->forProject($projectId);
    }

    public function withProject(): array
    {
        return $this->model->withProject();
    }
}
