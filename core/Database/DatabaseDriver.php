<?php

declare(strict_types=1);

namespace Core\Database;

use PDO;

interface DatabaseDriver
{
    /** @param array<string, mixed> $config */
    public function connect(array $config): PDO;
}
