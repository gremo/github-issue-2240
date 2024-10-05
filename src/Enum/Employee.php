<?php

namespace App\Enum;

enum Employee: string
{
    case First = 'employee1';
    case Second = 'employee2';
    case Third = 'employee3';

    public function getReadable(): string
    {
        return match ($this) {
            self::First => 'Employee 1',
            self::Second => 'Employee 2',
            self::Third => 'Employee 3',
        };
    }
}
