<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Project;
use Core\Database\Connection;

class ProjectRepository implements ProjectRepositoryInterface
{
    private Project $model;

    public function __construct(Connection $connection)
    {
        $this->model = new Project($connection);
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
}













