<?php

declare(strict_types=1);

namespace App\Enums;

enum CourseStatus: string
{
    case NotStarted = 'not_started';
    case Passed = 'passed';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::NotStarted => 'Not Started',
            self::Passed => 'Passed',
            self::Failed => 'Failed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::NotStarted => 'zinc',
            self::Passed => 'green',
            self::Failed => 'red',
        };
    }
}
