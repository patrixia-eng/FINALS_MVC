<?php

declare(strict_types=1);

namespace App\Enums;

// Task status values used in forms and database
class TaskStatus
{
    public const Pending = 'pending';
    public const InProgress = 'in_progress';
    public const Completed = 'completed';

    /** @return list<string> */
    public static function values(): array
    {
        return [self::Pending, self::InProgress, self::Completed];
    }

    /** @return list<array{value: string, label: string}> */
    public static function options(): array
    {
        return [
            ['value' => self::Pending, 'label' => 'Pending'],
            ['value' => self::InProgress, 'label' => 'In Progress'],
            ['value' => self::Completed, 'label' => 'Completed'],
        ];
    }

    public static function label(string $value): string
    {
        return match ($value) {
            self::InProgress => 'In Progress',
            self::Completed => 'Completed',
            default => 'Pending',
        };
    }
}
