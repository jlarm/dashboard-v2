<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Store;
use App\Traits\HasAuditStats;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

abstract class AbstractAuditStats extends Component
{
    use HasAuditStats;

    public Store $store;
    protected ?object $memoizedLatestAudit = null;

    abstract protected function violationAuditQuery(): Builder;

    abstract protected function auditQuery(): Builder;

    abstract protected function viewName(): string;

    final public function mount(): void
    {
        $this->store ??= (app()->bound('currentStoreModel') ? app('currentStoreModel') : null) ?? Store::query()->first();
    }

    final public function rating(): string
    {
        $grade = $this->getLatestAuditRecord()->grade;

        return ($grade && $grade !== 'N/A') ? $grade : 'N/A';
    }

    final public function pdfPath(): ?string
    {
        $path = $this->getLatestAuditRecord()->pdf_path;

        return empty($path) ? null : $path;
    }

    final public function downloadPdf()
    {
        return Storage::disk('armpaudits')->download($this->pdfPath());
    }

    final public function render(): View
    {
        return view($this->viewName());
    }

    protected function violationAudits(): Builder
    {
        return $this->violationAuditQuery()->where('store_id', $this->store->id);
    }

    protected function getLatestAuditRecord()
    {
        if ($this->memoizedLatestAudit !== null) {
            return $this->memoizedLatestAudit;
        }

        return $this->memoizedLatestAudit = $this->violationAudits()
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->first(['grade', 'pdf_path']) ?? (object) ['grade' => 'N/A', 'pdf_path' => null];
    }
}
