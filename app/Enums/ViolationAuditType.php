<?php

declare(strict_types=1);

namespace App\Enums;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;

enum ViolationAuditType: string
{
    case Osha = 'osha';
    case BodyShop = 'body-shop';
    case Glba = 'finance';

    public static function fromSlug(string $slug): self
    {
        return self::from($slug);
    }

    public function slug(): string
    {
        return $this->value;
    }

    public function label(): string
    {
        return match ($this) {
            self::Osha => 'OSHA',
            self::BodyShop => 'Body Shop',
            self::Glba => 'GLBA',
        };
    }

    /**
     * @return class-string<\App\Models\Dealer\Audit\Contracts\ViolationAudit>
     */
    public function modelClass(): string
    {
        return match ($this) {
            self::Osha => OshaViolationAudit::class,
            self::BodyShop => BodyShopViolationAudit::class,
            self::Glba => GlbaViolationAudit::class,
        };
    }

    /**
     * @return class-string
     */
    public function legacyModelClass(): string
    {
        return match ($this) {
            self::Osha => OshaAudit::class,
            self::BodyShop => BodyShopAudit::class,
            self::Glba => FinanceAudit::class,
        };
    }

    public function violationStatementCategory(): ViolationStatementCategory
    {
        return match ($this) {
            self::Osha => ViolationStatementCategory::Osha,
            self::BodyShop => ViolationStatementCategory::BodyShop,
            self::Glba => ViolationStatementCategory::Glba,
        };
    }
}
