<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use Illuminate\Database\Eloquent\Builder;

class BodyShopStats extends AbstractAuditStats
{
    protected function violationAuditQuery(): Builder
    {
        return BodyShopViolationAudit::query();
    }

    protected function auditQuery(): Builder
    {
        return BodyShopAudit::query();
    }

    protected function viewName(): string
    {
        return 'livewire.dealer.home.body-shop-stats';
    }
}
