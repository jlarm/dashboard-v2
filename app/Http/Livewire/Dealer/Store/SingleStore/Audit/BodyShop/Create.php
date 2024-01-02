<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Create extends Component
{
    public Store $store;

    public function mount()
    {
        $audit = BodyShopAudit::create([
            'user_id' => auth()->id(),
            'store_id' => $this->store->id ?? Store::first()->id,
            'audit_date' => now()->format('Y-m-d'),
        ]);

        return redirect()->to(route('dealer.stores.audits.body-shop.show', [$this->store, $audit->id]));
    }
}
