<?php

declare(strict_types=1);

namespace App\Enums;

enum Audit: string
{
    case OSHA = 'osha';
    case BodyShop = 'bodyshop';
    case GLBA = 'glba';
    case Individual = 'individual';

    public function getStatements(): string
    {
        return match ($this) {
            self::OSHA => 'OshaViolationStatements',
            self::BodyShop => 'BodyShopViolationStatements',
            self::GLBA => 'GlbaViolationStatements',
            self::Individual => 'IndividualViolationStatements',
        };
    }
}
