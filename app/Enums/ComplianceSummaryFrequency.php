<?php

declare(strict_types=1);

namespace App\Enums;

enum ComplianceSummaryFrequency: string
{
    case Monthly = 'monthly';
    case Quarterly = 'quarterly';

    public function label(): string
    {
        return match ($this) {
            self::Monthly => 'Monthly',
            self::Quarterly => 'Quarterly',
        };
    }

    /**
     * Determines whether a summary is due today based on the frequency.
     * Monthly:   first day of every month.
     * Quarterly: first day of January, April, July, October.
     */
    public function isDueToday(): bool
    {
        return match ($this) {
            self::Monthly => now()->day === 1,
            self::Quarterly => now()->day === 1 && in_array(now()->month, [1, 4, 7, 10], true),
        };
    }

    /**
     * Human-readable label for the period covered by this report.
     * Monthly:   the previous calendar month (e.g. "March 2026").
     * Quarterly: the previous quarter (e.g. "Q1 2026").
     */
    public function periodLabel(): string
    {
        return match ($this) {
            self::Monthly => now()->subMonth()->format('F Y'),
            self::Quarterly => 'Q'.(int) ceil(now()->subMonth()->month / 3).' '.now()->subMonth()->year,
        };
    }
}
