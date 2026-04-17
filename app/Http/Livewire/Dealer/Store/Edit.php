<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Edit extends Component
{
    public Store $store;
    public $name;
    public $address;
    public $city;
    public $state;
    public $postal_code;
    public $phone;
    public $website;
    protected $rules = [
        'name' => 'required|max:255',
        'address' => 'required|max:255',
        'city' => 'required|max:255',
        'state' => 'required|max:255',
        'postal_code' => 'required|max:255',
        'phone' => 'required|max:255',
        'website' => 'required|max:255',
    ];

    public function mount(): void
    {
        $this->name = $this->store->name;
        $this->address = $this->store->address;
        $this->city = $this->store->city;
        $this->state = $this->store->state;
        $this->postal_code = $this->store->postal_code;
        $this->phone = $this->store->phone;
        $this->website = $this->store->website;
    }

    public function updateStore(): void
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

        $this->dispatch('refreshStoreDetails')->to('dealer.store.details');

        $this->close();
    }

    public function close(): void
    {
        $this->dispatch('slide-over.close');
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.store.edit');
    }
}
