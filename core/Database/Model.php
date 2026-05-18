<?php

declare(strict_types=1);

namespace Core\Database;

abstract class Model implements Findable, Persistable
{
    public function __construct(
        protected Connection $connection,
    ) {}

    abstract protected function table(): string;

    protected function query(): QueryBuilder
    {
        return (new QueryBuilder($this->connection->pdo()))->table($this->table());
    }

    public function all(): array
    {
        return $this->query()->orderBy('id', 'DESC')->get();
    }

    public function find(int $id): ?array
    {
        return $this->query()->where('id', $id)->first();
    }

    public function create(array $data): int
    {
        return $this->query()->insert($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->query()->where('id', $id)->update($data) > 0;
    }

    public function delete(int $id): bool
    {
        return $this->query()->where('id', $id)->delete() > 0;
    }
}
