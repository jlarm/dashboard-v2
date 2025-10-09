<?php

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

    public function mount()
    {
        $this->store = $this->store ?? null;
    }

    public function render()
    {
        return view('livewire.dealer.vendor.index', [
            'vendors' => $this->store
                ? Vendor::where('store_id', $this->store->id)
                    ->orWhere('store_id', null)
                    ->orderBy('name')
                    ->paginate(16)
                : Vendor::orderBy('name')->paginate(16),
        ])->layout('components.dealer-app');
    }
}
