<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Jobs\SendVendorEmailJob;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use Filament\Notifications\Notification;
use Livewire\WithPagination;
use WireElements\Pro\Components\SlideOver\SlideOver;

class Edit extends SlideOver
{
    use WithPagination;

    public $vendor;

    public string $name = '';

    public string $email = '';

    protected $listeners = ['refreshVendorForms' => '$refresh'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
    ];

    public function mount(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function send(): void
    {
        $this->validate();

        $vendorForm = $this->createVendorForm();

        SendVendorEmailJob::dispatch($vendorForm);

        $this->reset(['name', 'email']);

        $this->emit('refreshVendorForms');
        $this->emit('refreshVendors');

        Notification::make()
            ->title('Email Successfully Sent!')
            ->success()
            ->send();
    }

    private function createVendorForm()
    {
        return $this->vendor->forms()->create([
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }

    public function render()
    {
        return view('livewire.dealer.vendor.edit', [
            'forms' => $this->vendor->forms()->latest()->paginate(5),
            'stores' => Store::orderBy('name')->get(),
        ]);
    }
}
