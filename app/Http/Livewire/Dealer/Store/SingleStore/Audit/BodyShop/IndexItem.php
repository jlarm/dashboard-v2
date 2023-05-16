<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class IndexItem extends Component
{
    public BodyShopAudit $bodyShopAudit;
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.store.single-store.audit.body-shop.index-item')->layout('components.dealer-app');
    }
}
