<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public BodyShopViolationAudit $bodyShopAudit;

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
        return $this->bodyShopAudit->date->format('Y').' Q'.ceil($this->bodyShopAudit->date->format('n') / 3);
    }

    public function download()
    {
        return \Storage::disk('armpaudits')->download($this->bodyShopAudit->pdf_path);
    }

    public function remediationsActive(): bool
    {
        return $this->store->remediationSettings !== null && $this->store->remediationSettings->exists() && $this->store->remediationSettings->first()->active;
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.body-shop.index-item');
    }
}
