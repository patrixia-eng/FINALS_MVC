<?php

declare(strict_types=1);

namespace Core\Database;

interface Persistable
{
    /** @param array<string, mixed> $data */
    public function create(array $data): int;

    /** @param array<string, mixed> $data */
    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
