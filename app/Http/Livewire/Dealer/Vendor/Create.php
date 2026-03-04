<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Vendor;

use App\Jobs\SendVendorEmailJob;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use WireElements\Pro\Components\Modal\Modal;

class Create extends Modal
{
    public $name;
    public $user;
    public $qi;
    public $contact_name;
    public $contact_email;
    public $store;
    protected $rules = [
        'name' => 'required|max:255|unique:vendors,name',
        'contact_name' => 'required|max:255',
        'contact_email' => 'required|max:255',
        'store' => 'nullable|integer|exists:stores,id',
    ];

    public function mount(): void
    {
        $this->qi = User::role('Qualified Individual')->first();
    }

    public function create(): void
    {
        $this->validate();

        $vendor = $this->createVendor();

        $vendorForm = $this->createVendorForm($vendor);

        SendVendorEmailJob::dispatch($vendorForm);

        $this->reset();

        $this->emit('refreshVendors');

        $this->close();

        Notification::make()
            ->title('Vendor Successfully Created!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.dealer.vendor.create', [
            'stores' => app('multipleStoresExist') ? Store::query()->orderBy('name')->get() : null,
        ]);
    }

    private function createVendor()
    {
        return Vendor::query()->create([
            'name' => $this->name,
            'contact_name' => $this->contact_name,
            'contact_email' => $this->contact_email,
            'store_id' => $this->store !== '' ? $this->store : null,
        ]);
    }

    private function createVendorForm($vendor)
    {
        return $vendor->forms()->create([
            'name' => $vendor->contact_name,
            'email' => $vendor->contact_email,
        ]);
    }
}
