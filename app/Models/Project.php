<?php

declare(strict_types=1);

namespace App\Models;

use Core\Database\Model;

class Project extends Model
{
    protected function table(): string
    {
        return 'projects';
    }
}
