<?php

namespace App\Enums;

enum DealerRoles
{
    const ADMIN = 'admin';

    const MANAGER = 'manager';

    const EMPLOYEE = 'employee';

    protected static function labels(): array
    {
        return [
            self::ADMIN => 'Admin',
            self::MANAGER => 'Manager',
            self::EMPLOYEE => 'Employee',
        ];
    }
}
