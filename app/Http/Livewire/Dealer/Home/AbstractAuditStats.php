<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Store;
use App\Traits\HasAuditStats;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;

abstract class AbstractAuditStats extends Component
{
    use HasAuditStats;

    public Store $store;

    abstract protected function violationAuditQuery(): Builder;

    abstract protected function auditQuery(): Builder;

    abstract protected function viewName(): string;

    final public function mount(): void
    {
        $this->store ??= app('currentStoreModel') ?? Store::query()->first();
    }

    final public function rating(): string
    {
        $latestGrade = $this->violationAudits()
            ->whereNotNull('grade')
            ->where('grade', '!=', 'N/A')
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->value('grade');

        return $latestGrade ?? 'N/A';
    }

    final public function render(): View
    {
        return view($this->viewName());
    }

    protected function violationAudits(): Builder
    {
        return $this->violationAuditQuery()->where('store_id', $this->store->id);
    }
}
