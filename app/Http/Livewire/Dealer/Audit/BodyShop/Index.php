<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['refreshBodyShopAudits' => '$refresh'];
    public function render()
    {
        return view('livewire.dealer.audit.body-shop.index', [
            'audits' => BodyShopAudit::orderBy('audit_date', 'desc')
                ->latest()
                ->with('store')
                ->orderBy('audit_date')
                ->select('id', 'store_id', 'audit_date', 'pdf_path')
                ->get()
        ]);
    }
}
