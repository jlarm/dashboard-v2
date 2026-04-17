<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $store;

    public function mount(Store $store): void
    {
        $this->store = $store;
    }

    public function deleteStore(): void
    {
        $this->store->delete();

        $this->redirect(route('dealer.dashboard'));

        Notification::make()
            ->title('Store Deleted Successfully!')
            ->success()
            ->send();
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.store.delete');
    }
}
