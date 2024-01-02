<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Audit\BodyShopAudit;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $bodyShopAudit;

    public function mount(BodyShopAudit $bodyShopAudit)
    {
        $this->bodyShopAudit = $bodyShopAudit;
    }

    public function delete()
    {
        $this->bodyShopAudit->delete();

        $this->emitTo('dealer.audit.body-shop.index', 'refreshBodyShopAudits');
        $this->emitTo('dealer.store.single-store.audit.body-shop.index', 'refreshStoreBodyShopAudits');

        $this->close();

        Notification::make()
            ->title('Body Shop Audit Deleted Successfully!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.audit.body-shop.delete');
    }
}
