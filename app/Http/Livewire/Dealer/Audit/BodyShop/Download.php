<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use Livewire\Component;
use Storage;

class Download extends Component
{
    public BodyShopAudit $bodyShopAudit;

    public function download()
    {
        return Storage::disk('do-audits')->download(tenant('id') . '/audits/body-shop/' . '/body-shop-audit.pdf');
    }
    public function render()
    {
        return view('livewire.dealer.audit.body-shop.download');
    }
}
