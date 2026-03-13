<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Http\Livewire\Concerns\ResolvesDashboardStore;
use App\Models\Dealer\Store;
use App\Traits\HasAuditStats;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class AbstractAuditStats extends Component
{
    use HasAuditStats;
    use ResolvesDashboardStore;

    public ?Store $store = null;
    protected ?object $memoizedLatestAudit = null;

    abstract protected function violationAuditQuery(): Builder;

    abstract protected function auditQuery(): Builder;

    abstract protected function viewName(): string;

    final public function mount(): void
    {
        $this->store ??= $this->resolveDashboardStore();
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

    final public function downloadPdf(): StreamedResponse
    {
        $path = $this->pdfPath();

        abort_if($path === null, 404);

        return Storage::disk('armpaudits')->download($path);
    }

    final public function render(): View
    {
        return view($this->viewName());
    }

    protected function violationAudits(): Builder
    {
        if (! $this->store instanceof Store) {
            return $this->violationAuditQuery()->whereRaw('1 = 0');
        }

        return $this->violationAuditQuery()->where('store_id', $this->store->id);
    }

    protected function getLatestAuditRecord(): object
    {
        if ($this->memoizedLatestAudit !== null) {
            return $this->memoizedLatestAudit;
        }

        return $this->memoizedLatestAudit = $this->violationAudits()
            ->whereNotNull('grade')
            ->where('grade', '!=', 'N/A')
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->first(['grade', 'pdf_path']) ?? (object) ['grade' => 'N/A', 'pdf_path' => null];
    }
}
