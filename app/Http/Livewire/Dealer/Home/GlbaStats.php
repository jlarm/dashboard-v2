<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use Illuminate\Database\Eloquent\Builder;

class GlbaStats extends AbstractAuditStats
{
    protected function violationAuditQuery(): Builder
    {
        return GlbaViolationAudit::query();
    }

    protected function auditQuery(): Builder
    {
        return FinanceAudit::query();
    }

    protected function viewName(): string
    {
        return 'livewire.dealer.home.glba-stats';
    }
}
