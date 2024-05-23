<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use Livewire\Component;

class IndexItem extends Component
{
    public BodyShopViolationAudit $bodyShopAudit;

    public $store;

    protected $listeners = [
        'pdfGenerated' => '$refresh',
    ];

    public function quarter(): string
    {
        return $this->bodyShopAudit->date->format('Y').' Q'.ceil($this->bodyShopAudit->date->format('n') / 3);
    }

    public function download()
    {
        return \Storage::disk('armpaudits')->download($this->bodyShopAudit->pdf_path);
    }

    public function render()
    {
        return view('livewire.dealer.audit.body-shop.index-item');
    }
}
