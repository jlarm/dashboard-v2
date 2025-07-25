<?php

namespace App\Enums;

enum Service: string
{
    case GLBA = 'glba';
    case OSHA = 'osha';
    case IT = 'it';
    case CES = 'ces';

    public function label(): string
    {
        return match ($this) {
            self::GLBA => 'GLBA - Safeguards Rule, Sales & Finance',
            self::OSHA => 'OSHA',
            self::IT => 'IT Security',
            self::CES => 'Cyber Enhanced Security',
        };
    }
}
