<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Location;

use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

/**
 * @property-read Collection<int, Store> $stores
 */
class Index extends Component
{
    protected $listeners = ['refreshLocations' => '$refresh'];

    public function getStoresProperty(): Collection
    {
        return Store::query()
            ->orderBy('name')
            ->get(['id', 'name', 'city', 'state']);
    }

    public function openEditModal(int $storeId): void
    {
        $store = Store::query()->findOrFail($storeId);

        $this->dispatch('modal.open', 'tenant.location.edit-store-modal', ['storeId' => $store->id]);
    }

    public function render(): View
    {
        return view('livewire.tenant.location.index');
    }
}
