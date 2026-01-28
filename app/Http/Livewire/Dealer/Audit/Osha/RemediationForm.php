<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Http\Livewire\Dealer\Audit\Traits\UpdateRemediations;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class RemediationForm extends Component
{
    use InteractsWithConfirmationModal, UpdateRemediations, WithFileUploads, WithMedia;

    public ?Store $store = null;
    public OshaViolationAudit $oshaViolationAudit;
    public array $violationRemediations = [];

    public function mount(): void
    {
        $this->loadRemediations();
    }

    public function render()
    {
        return view('livewire.dealer.audit.osha.remediation-form', [
            'violations' => $this->violations()->get(),
        ])->layout('components.dealer-app');
    }

    protected function violations()
    {
        return $this->oshaViolationAudit->violations()->with(['remediation', 'remediation.user']);
    }

    private function loadRemediations(): void
    {
        $this->violationRemediations = $this->violations()->get()->mapWithKeys(function ($violation) {
            return [$violation->id => [
                'comment' => $violation->remediation?->comment ?? '',
                'completed' => $violation->remediation?->completed,
            ]];
        })->toArray();
    }
}
