<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.dealer.audit.body-shop.index', [
            'audits' => BodyShopAudit::latest()->select('id', 'draft', 'created_at')->get()
        ]);
    }
}
