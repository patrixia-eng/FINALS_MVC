<?php

declare(strict_types=1);

namespace Core\Database;

interface Findable
{
    /** @return list<array<string, mixed>> */
    public function all(): array;

    public function find(int $id): ?array;
}
