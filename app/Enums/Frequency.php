<?php

declare(strict_types=1);

namespace App\Enums;

enum Frequency: string
{
    case WEEKLY = 'weekly';
    case BI_WEEKLY = 'bi-weekly';
    case MONTHLY = 'monthly';

    public function label(): string
    {
        return match ($this) {
            self::WEEKLY => 'Weekly',
            self::BI_WEEKLY => 'Bi-Weekly',
            self::MONTHLY => 'Monthly',
        };
    }

    public function value(): int
    {
        return match ($this) {
            self::WEEKLY => 7,
            self::BI_WEEKLY => 14,
            self::MONTHLY => 30,
        };
    }
}
