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
//        BodyShopAudit::destroy($this->bodyShopAudit->id);
//
//        $media = Media::where('model_id', $this->bodyShopAudit->id);
//        $media->delete();

        $this->emitTo('dealer.audit.body-shop.index', 'refreshAudits');

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
