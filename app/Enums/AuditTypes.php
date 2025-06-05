<?php

namespace App\Enums;

enum AuditTypes: string
{
    case OSHA = 'OSHA';
    case BODYSHOP = 'BODYSHOP';
    case GLBA = 'GLBA';

    public function label(): string
    {
        return match ($this) {
            self::OSHA => 'OSHA',
            self::BODYSHOP => 'Body Shop',
            self::GLBA => 'GLBA',
        };
    }
}
