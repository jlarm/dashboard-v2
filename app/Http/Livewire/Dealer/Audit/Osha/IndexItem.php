<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public OshaViolationAudit $oshaAudit;

    public Store $store;
    public bool $remediations;

    protected $listeners = [
        'pdfGenerated' => '$refresh',
    ];

    public function mount(): void
    {
        $this->store = Store::find(app('currentStore'));
        $this->remediations = $this->store->remediations;
    }

    public function quarter(): string
    {
        return $this->oshaAudit->date->format('Y').' Q'.ceil($this->oshaAudit->date->format('n') / 3);
    }

    public function download()
    {
        return Storage::disk('armpaudits')->download($this->oshaAudit->pdf_path);
    }

    public function remediationsActive(): bool
    {
        return $this->store->remediationSettings->exists() && $this->store->remediationSettings->first()->active;
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.osha.index-item');
    }
}
