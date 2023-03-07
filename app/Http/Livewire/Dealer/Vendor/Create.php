<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Notifications\VendorFormNotification;
use Illuminate\Contracts\View\View;
use Notification;
use WireElements\Pro\Components\Modal\Modal;

class Create extends Modal
{
    public $name;

    public $contact_name;

    public $contact_email;

    public $store_id;

    protected $rules = [
        'name' => 'required|max:255|unique:vendors,name',
        'contact_name' => 'required|max:255',
        'contact_email' => 'required|max:255',
        'store_id' => 'nullable|max:255',
    ];

    public function create()
    {
        $validated = $this->validate();

        $vendor = Vendor::create([
            'name' => $this->name,
            'contact_name' => $this->contact_name,
            'contact_email' => $this->contact_email,
            'store_id' => $this->store_id ?? null,
        ]);

        Notification::route('mail', $this->contact_email)
            ->notify(new VendorFormNotification($vendor));

        $this->reset();

        $this->emit('refreshVendors');

        $this->close();
    }

    public function render(): View
    {
        return view('livewire.dealer.vendor.create', [
            'stores' => Store::orderBy('name')->get(),
        ]);
    }
}
