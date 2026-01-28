<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\ScanSetting;
use App\Models\Dealer\Store;
use Livewire\Component;

class SingleStoreScanSettings extends Component
{
    public $store;
    public $dealer;
    public $name;
    protected $rules = [
        'name' => 'string|max:255',
    ];

    public function mount(Store $store)
    {
        if ($store->id === null) {
            $this->dealer = ScanSetting::first();
        } else {
            $this->dealer = ScanSetting::where('store_id', $this->store->id)->first();
        }
    }

    public function update()
    {
        $this->validate();

        $this->scan->update([
            'name' => $this->name,
        ]);

        return redirect(route('dealer.stores.scans'));

    }

    public function render()
    {
        return view('livewire.dealer.store.single-store-scan-settings')->layout('components.dealer-app');
    }
}
