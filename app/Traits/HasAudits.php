<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasAudits
{
    public function individualAudits(): HasMany
    {
        return $this->hasMany(IndividualAudit::class, 'manager_id', 'id');
    }

    public function oshaViolationAudits(): HasMany
    {
        return $this->hasMany(OshaViolationAudit::class);
    }

    public function bodyShopViolationAudits(): HasMany
    {
        return $this->hasMany(BodyShopViolationAudit::class);
    }

    public function glbaViolationAudits(): HasMany
    {
        return $this->hasMany(GlbaViolationAudit::class);
    }

    public function oshaAudits(): HasMany
    {
        return $this->hasMany(OshaAudit::class);
    }

    public function bodyShopAudits(): HasMany
    {
        return $this->hasMany(BodyShopAudit::class);
    }

    public function glbaAudits(): HasMany
    {
        return $this->hasMany(FinanceAudit::class);
    }
}
