<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\ScanSetting;
use App\Models\Dealer\Settings\EmployeeList;
use App\Models\Dealer\Store;
use App\Models\Dealer\StoreSettings;
use Filament\Notifications\Notification;
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
        'name' => 'required|max:255|unique:stores,name|regex:/^[a-zA-Z0-9 ]+$/',
        'address' => 'required|max:255',
        'city' => 'required|max:255',
        'state' => 'required|max:255',
        'postal_code' => 'required|max:255',
        'phone' => 'required',
        'website' => 'required|max:255',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createStore()
    {
        $this->validate();

        $store = Store::create([
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'website' => $this->website,
        ]);

        StoreSettings::create([
            'store_id' => $store->id,
            'name' => $store->name,
            'address' => $store->address,
            'city' => $store->city,
            'state' => $store->state,
            'postal_code' => $store->postal_code,
            'phone' => $store->phone,
            'website' => $store->website,
        ]);

        EmployeeList::create(['store_id' => $store->id]);
        ScanSetting::create(['store_id' => $store->id]);

        $this->reset();

        $this->emit('refreshStores');

        $this->close();

        Notification::make()
            ->title('Store Created Successfully!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.store.create');
    }
}
