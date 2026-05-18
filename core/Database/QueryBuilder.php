<?php

declare(strict_types=1);

namespace Core\Database;

use PDO;

final class QueryBuilder
{
    private string $table = '';
    /** @var list<string> */
    private array $wheres = [];
    /** @var array<string, mixed> */
    private array $bindings = [];
    private ?string $orderBy = null;
    private ?int $limit = null;

    public function __construct(
        private PDO $pdo,
    ) {}

    public function table(string $table): self
    {
        $clone = clone $this;
        $clone->table = $table;
        $clone->wheres = [];
        $clone->bindings = [];
        $clone->orderBy = null;
        $clone->limit = null;

        return $clone;
    }

    public function where(string $column, mixed $value): self
    {
        $this->wheres[] = "{$column} = ?";
        $this->bindings[] = $value;

        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->orderBy = "{$column} {$direction}";

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /** @return list<array<string, mixed>> */
    public function get(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $sql .= $this->buildWhere();
        $sql .= $this->orderBy ? " ORDER BY {$this->orderBy}" : '';
        $sql .= $this->limit !== null ? " LIMIT {$this->limit}" : '';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);

        return $stmt->fetchAll();
    }

    /** @return array<string, mixed>|null */
    public function first(): ?array
    {
        $this->limit = 1;
        $rows = $this->get();

        return $rows[0] ?? null;
    }

    /** @param array<string, mixed> $data */
    public function insert(array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));

        return (int) $this->pdo->lastInsertId();
    }

    /** @param array<string, mixed> $data */
    public function update(array $data): int
    {
        $sets = [];
        $values = [];

        foreach ($data as $column => $value) {
            $sets[] = "{$column} = ?";
            $values[] = $value;
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets);
        $sql .= $this->buildWhere();

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([...$values, ...$this->bindings]);

        return $stmt->rowCount();
    }

    public function delete(): int
    {
        $sql = "DELETE FROM {$this->table}";
        $sql .= $this->buildWhere();

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);

        return $stmt->rowCount();
    }

    private function buildWhere(): string
    {
        if ($this->wheres === []) {
            return '';
        }

        return ' WHERE ' . implode(' AND ', $this->wheres);
    }
}
