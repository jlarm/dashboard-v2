<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['refreshAudits' => '$refresh'];
    public function render()
    {
        return view('livewire.dealer.audit.body-shop.index', [
            'audits' => BodyShopAudit::latest()->with('store')->select('id', 'store_id', 'draft', 'audit_date', 'pdf_path')->get()
        ]);
    }
}
