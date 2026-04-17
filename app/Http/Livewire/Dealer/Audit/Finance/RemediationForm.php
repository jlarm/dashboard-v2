<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Http\Livewire\Dealer\Audit\Traits\UpdateRemediations;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class RemediationForm extends Component
{
    use InteractsWithConfirmationModal, UpdateRemediations, WithFileUploads, WithMedia;

    public ?Store $store = null;
    public GlbaViolationAudit $glbaViolationAudit;
    public array $violationRemediations = [];
    private ?Collection $memoizedViolations = null;

    public function mount(): void
    {
        $this->loadRemediations();
    }

    public function render()
    {
        return view('livewire.dealer.audit.finance.remediation-form', [
            'violations' => $this->memoizedViolations ??= $this->violations()->get(),
        ])->layout('components.dealer-app');
    }

    protected function violations()
    {
        return $this->glbaViolationAudit->violations()->with(['remediation', 'remediation.user']);
    }

    private function loadRemediations(): void
    {
        $this->violationRemediations = ($this->memoizedViolations ??= $this->violations()->get())->mapWithKeys(fn ($violation): array => [$violation->id => [
            'comment' => $violation->remediation?->comment ?? '',
            'completed' => $violation->remediation?->completed,
        ]])->toArray();
    }
}
