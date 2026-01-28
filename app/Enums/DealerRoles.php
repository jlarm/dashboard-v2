<?php

declare(strict_types=1);

namespace App\Enums;

enum DealerRoles
{
    public const ADMIN = 'admin';

    public const MANAGER = 'manager';

    public const EMPLOYEE = 'employee';

    private static function labels(): array
    {
        return [
            self::ADMIN => 'Admin',
            self::MANAGER => 'Manager',
            self::EMPLOYEE => 'Employee',
        ];
    }
}
