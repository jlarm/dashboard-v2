<?php

declare(strict_types=1);

namespace App\Enums;

enum ViolationStatementCategory: string
{
    case Osha = 'osha';
    case BodyShop = 'body_shop';
    case Glba = 'glba';

    public function label(): string
    {
        return match ($this) {
            self::Osha => 'OSHA',
            self::BodyShop => 'Body Shop',
            self::Glba => 'GLBA',
        };
    }
}
