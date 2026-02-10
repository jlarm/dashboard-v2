<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use Illuminate\Support\Facades\Storage;
use App\Models\Dealer\Audit\BodyShopAudit;
use Livewire\Component;

class Download extends Component
{
    public BodyShopAudit $bodyShopAudit;
    public $content;

    public function mount(): void
    {

        $this->content = Storage::disk('do-audits')->url(tenant('id').'/body-shop/'.$this->bodyShopAudit->pdf_path);
    }

    public function render()
    {
        return view('livewire.dealer.audit.body-shop.download');
    }
}
