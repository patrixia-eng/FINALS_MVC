<?php

declare(strict_types=1);

namespace App\Support;

// Simple validation helper I made for forms
class Validator
{
    private array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;

            foreach ($fieldRules as $rule) {
                if ($rule === 'required') {
                    if ($value === null || $value === '') {
                        $this->errors[$field][] = ucfirst($field) . ' is required.';
                    }
                } elseif ($rule === 'date') {
                    if ($value !== null && $value !== '') {
                        $d = \DateTime::createFromFormat('Y-m-d', (string) $value);
                        if (!$d || $d->format('Y-m-d') !== $value) {
                            $this->errors[$field][] = 'Invalid date format.';
                        }
                    }
                } elseif (strpos($rule, 'max:') === 0) {
                    $max = (int) substr($rule, 4);
                    if (is_string($value) && strlen($value) > $max) {
                        $this->errors[$field][] = ucfirst($field) . ' is too long.';
                    }
                } elseif (strpos($rule, 'in:') === 0) {
                    $allowed = explode(',', substr($rule, 3));
                    if ($value !== null && $value !== '' && !in_array((string) $value, $allowed)) {
                        $this->errors[$field][] = 'Invalid value selected.';
                    }
                }
            }
        }

        return count($this->errors) === 0;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
