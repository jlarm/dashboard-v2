<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public GlbaViolationAudit $glbaViolationAudit;

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
        return $this->glbaViolationAudit->date->format('Y').' Q'.ceil($this->glbaViolationAudit->date->format('n') / 3);
    }

    public function download()
    {
        return \Storage::disk('armpaudits')->download($this->glbaViolationAudit->pdf_path);
    }

    public function remediationsActive(): bool
    {
        return $this->store->remediationSettings->first()->active;
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.finance.index-item');
    }
}
