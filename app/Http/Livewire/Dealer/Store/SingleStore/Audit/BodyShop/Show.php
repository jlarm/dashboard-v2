<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Show extends Component
{
    public Store $store;
    public BodyShopAudit $bodyShopAudit;

    public function render()
    {
        return view('livewire.dealer.store.single-store.audit.body-shop.show')->layout('components.dealer-app');
    }
}
