<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?Store $store = null;
    protected $listeners = ['refreshVendors' => '$refresh'];

    public function mount(): void
    {
        $this->store ??= null;
    }

    public function render()
    {
        return view('livewire.dealer.vendor.index', [
            'vendors' => $this->store instanceof Store
                ? Vendor::with('store:id,name')
                    ->where('store_id', $this->store->id)
                    ->orWhere('store_id', null)
                    ->orderBy('name')
                    ->paginate(16)
                : Vendor::with('store:id,name')
                    ->orderBy('name')
                    ->paginate(16),
        ])->layout('components.dealer-app');
    }
}
