<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use WireElements\Pro\Components\SlideOver\SlideOver;

class Edit extends SlideOver
{
    public $store;
    public $name;
    public $address;
    public $city;
    public $state;
    public $postal_code;
    public $phone;
    public $website;

    public function mount(Store $store)
    {
        $this->store = $store;
        $this->name = $store->name;
        $this->address = $store->address;
        $this->city = $store->city;
        $this->state = $store->state;
        $this->postal_code = $store->postal_code;
        $this->phone = $store->phone;
        $this->website = $store->website;
    }

    public function updateStore()
    {
        $this->validate();

        $this->store->update([
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'website' => $this->website,
        ]);

        $this->emit('refreshStores');

        $this->close();
    }

    protected $rules = [
        'name' => 'required|max:255',
        'address' => 'required|max:255',
        'city' => 'required|max:255',
        'state' => 'required|max:255',
        'postal_code' => 'required|max:255',
        'phone' => 'required|max:255',
        'website' => 'required|max:255',
    ];

    public function render()
    {
        return view('livewire.dealer.store.edit');
    }
}
