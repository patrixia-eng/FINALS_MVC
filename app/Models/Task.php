<?php

declare(strict_types=1);

namespace App\Models;

use Core\Database\Connection;
use Core\Database\Model;

class Task extends Model
{
    protected function table(): string
    {
        return 'tasks';
    }

    /** @return list<array<string, mixed>> */
    public function forProject(int $projectId): array
    {
        return $this->query()
            ->where('project_id', $projectId)
            ->orderBy('due_date', 'ASC')
            ->get();
    }

    /** @return list<array<string, mixed>> */
    public function withProject(): array
    {
        $sql = <<<'SQL'
            SELECT tasks.*, projects.name AS project_name
            FROM tasks
            INNER JOIN projects ON projects.id = tasks.project_id
            ORDER BY tasks.due_date ASC, tasks.id DESC
        SQL;

        return $this->connection->pdo()->query($sql)->fetchAll();
    }
}
