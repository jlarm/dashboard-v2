<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Http\Livewire\Dealer\Audit\Traits\UpdateRemediations;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Store;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class RemediationForm extends Component
{
    use WithFileUploads, WithMedia, InteractsWithConfirmationModal, UpdateRemediations;

    public ?Store $store = null;
    public BodyShopViolationAudit $bodyShopViolationAudit;
    public array $violationRemediations = [];

    public function mount(): void
    {
        $this->loadRemediations();
    }

    protected function violations()
    {
        return $this->bodyShopViolationAudit->violations()->with('remediation');
    }

    private function loadRemediations(): void
    {
        $this->violationRemediations = $this->violations()->get()->pluck('remediation.comment', 'id')->map(function ($comment) {
            return ['comment' => $comment ?? ''];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.dealer.audit.body-shop.remediation-form', [
            'violations' => $this->violations()->with('remediation')->get(),
        ])->layout('components.dealer-app');
    }
}
