<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Jobs\SendVendorEmailJob;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\User;
use Illuminate\Contracts\View\View;
use WireElements\Pro\Components\Modal\Modal;

class Create extends Modal
{
    public $name;
    public $user;
    public $qi;

    public $contact_name;

    public $contact_email;

    public $store_id;

    protected $rules = [
        'name' => 'required|max:255|unique:vendors,name',
        'contact_name' => 'required|max:255',
        'contact_email' => 'required|max:255',
        'store_id' => 'nullable|max:255',
    ];

    public function mount()
    {
        $this->qi = User::role('Qualified Individual')->first();
    }

    public function create()
    {
        $validated = $this->validate();

        $vendor = Vendor::create([
            'name' => $this->name,
            'contact_name' => $this->contact_name,
            'contact_email' => $this->contact_email,
            'store_id' => $this->store_id ?? null,
        ]);

        SendVendorEmailJob::dispatch($vendor, $this->user);

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
