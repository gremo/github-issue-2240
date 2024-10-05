<?php

namespace App\Enum;

enum Office: string
{
    case First = 'office1';
    case Second = 'office2';
    case Third = 'office3';

    public function getReadable(): string
    {
        return match ($this) {
            self::First => 'Office 1',
            self::Second => 'Office 2',
            self::Third => 'Office 3',
        };
    }

    /**
     * @return list<Employee>
     */
    public function getEmployeeChoices(): array
    {
        return match ($this) {
            self::First => [Employee::First, Employee::Second],
            self::Second => [Employee::Third],
            self::Third => [],
        };
    }
}
