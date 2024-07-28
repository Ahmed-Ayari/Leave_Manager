<?php

namespace App\Enum;

enum LeaveType: string
{
    case Annual = 'annual';
    case Sick = 'sick';
    case Unpaid = 'unpaid';

    public function getLabel(): string
    {
        return match ($this) {
            self::Annual => 'Annual',
            self::Sick => 'Sick',
            self::Unpaid => 'Unpaid',
        };
    }
}