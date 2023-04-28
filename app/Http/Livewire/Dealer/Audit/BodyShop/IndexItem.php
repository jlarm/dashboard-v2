<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use Livewire\Component;

class IndexItem extends Component
{
    public BodyShopAudit $bodyShopAudit;
    public function render()
    {
        return view('livewire.dealer.audit.body-shop.index-item');
    }
}
