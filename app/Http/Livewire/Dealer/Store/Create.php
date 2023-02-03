<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use WireElements\Pro\Components\Modal\Modal;

class Create extends Modal
{
    public $name;

    public $address;

    public $city;

    public $state;

    public $postal_code;

    public $phone;

    public $website;

    protected $rules = [
        'name' => 'required|max:255|unique:stores,name',
        'address' => 'required|max:255',
        'city' => 'required|max:255',
        'state' => 'required|max:255',
        'postal_code' => 'required|max:255',
        'phone' => 'required|max:255',
        'website' => 'required|max:255',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createStore()
    {
        $this->validate();

        Store::create([
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'website' => $this->website,
        ]);

        $this->reset();

        $this->emit('refreshStores');

        $this->close();
    }

    public function render()
    {
        return view('livewire.dealer.store.create');
    }
}
