<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Download extends Component
{
    public BodyShopAudit $bodyShopAudit;
    public $content;

    public function mount(): void
    {

        $this->content = Storage::disk('do-audits')->url(tenant('id').'/body-shop/'.$this->bodyShopAudit->pdf_path);
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.audit.body-shop.download');
    }
}
