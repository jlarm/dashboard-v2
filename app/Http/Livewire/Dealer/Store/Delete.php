<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $store;

    public function mount(Store $store)
    {
        $this->store = $store;
    }

    public function deleteStore()
    {
        $this->store->delete();

        $this->redirect(route('dealer.stores.index'));

        Notification::make()
            ->title('Store Deleted Successfully!')
            ->success()
            ->send();
    }
    public function render()
    {
        return view('livewire.dealer.store.delete');
    }
}
