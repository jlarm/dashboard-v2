<?php

namespace App\Enums;

use PhpParser\Node\Scalar\String_;

enum Departments: string
{
    case  SALES = 'sales';
    case  MARKETING = 'marketing';
    case  FINANCE = 'finance';
    case  HR = 'hr';
    case  IT = 'it';
    case PARTS = 'parts';
    case SERVICE = 'service';

    public function label(): String
    {
        return match($this) {
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
