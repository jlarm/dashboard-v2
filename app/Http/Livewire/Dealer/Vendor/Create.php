<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Notifications\VendorFormNotification;
use Notification;
use WireElements\Pro\Components\Modal\Modal;

//use App\Notifications\VendorFormNotification;
//use Filament\Notifications\Notification;

class Create extends Modal
{
    public $name;

    public $contact_name;

    public $contact_email;
    public $stores;
    public $store;

    protected $rules = [
        'name' => 'required|max:255|unique:vendors,name',
        'contact_name' => 'required|max:255',
        'contact_email' => 'required|max:255',
        'store' => 'required|max:255',
    ];

    public function mount()
    {
        $this->stores = Store::all();
    }
    public function create()
    {
        $this->validate();

        $vendor = Vendor::create([
            'name' => $this->name,
            'contact_name' => $this->contact_name,
            'contact_email' => $this->contact_email,
        ]);

        Notification::route('mail', $this->contact_email)
            ->notify(new VendorFormNotification($vendor));

        $this->reset();

        $this->emit('refreshVendors');

        $this->close();
//
//        Notification::make()
//            ->success('Vendor created successfully.')
//            ->send();
    }
}
