<?php

declare(strict_types=1);

namespace App\Enums;

enum Departments: string
{
    case SALES = 'sales';
    case MARKETING = 'marketing';
    case FINANCE = 'finance';
    case HR = 'hr';
    case IT = 'it';
    case PARTS = 'parts';
    case SERVICE = 'service';

    public function label(): string
    {
        return match ($this) {
            self::SALES => 'Sales',
            self::MARKETING => 'Marketing',
            self::FINANCE => 'Finance',
            self::HR => 'HR',
            self::IT => 'IT',
            self::PARTS => 'Parts',
            self::SERVICE => 'Service',
        };
    }
}
