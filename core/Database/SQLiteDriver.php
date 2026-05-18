<?php

declare(strict_types=1);

namespace Core\Database;

use PDO;

final class SQLiteDriver implements DatabaseDriver
{
    public function connect(array $config): PDO
    {
        $path = $config['path'] ?? '';
        $directory = dirname($path);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $pdo = new PDO('sqlite:' . $path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}
