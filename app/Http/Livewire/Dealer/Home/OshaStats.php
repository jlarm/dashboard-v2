<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use Illuminate\Database\Eloquent\Builder;

class OshaStats extends AbstractAuditStats
{
    protected function violationAuditQuery(): Builder
    {
        return OshaViolationAudit::query();
    }

    protected function auditQuery(): Builder
    {
        return OshaAudit::query();
    }

    protected function viewName(): string
    {
        return 'livewire.dealer.home.osha-stats';
    }
}
