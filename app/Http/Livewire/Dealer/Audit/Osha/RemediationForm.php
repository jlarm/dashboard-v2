<?php

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
    use WithFileUploads, WithMedia, InteractsWithConfirmationModal, UpdateRemediations;

    public ?Store $store = null;
    public OshaViolationAudit $oshaViolationAudit;
    public array $violationRemediations = [];

    public function mount(): void
    {
        $this->loadRemediations();
    }

    protected function violations()
    {
        return $this->oshaViolationAudit->violations()->with('remediation');
    }

    private function loadRemediations(): void
    {
        $this->violationRemediations = $this->violations()->get()->pluck('remediation.comment', 'id')->map(function ($comment) {
            return ['comment' => $comment ?? ''];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.dealer.audit.osha.remediation-form', [
            'violations' => $this->violations()->with('remediation')->get(),
        ])->layout('components.dealer-app');
    }
}
