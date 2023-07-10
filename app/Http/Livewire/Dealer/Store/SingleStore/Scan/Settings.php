<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Scan;

use App\Models\Dealer\Store;
use Livewire\Component;

class Settings extends Component
{
    public Store $store;
    public $name;

    protected $rules = [
        'name' => 'string|max:255',
    ];

    public function mount()
    {
        $this->name = $this->store->scanSetting->name;
    }

    public function update()
    {
        $this->validate();

        $this->store->scanSetting()->update([
            'name' => $this->name,
        ]);

        return redirect(route('dealer.stores.scans', $this->store));

    }

    public function render()
    {
        return view('livewire.dealer.store.single-store.scan.settings')->layout('components.dealer-app');
    }
}
