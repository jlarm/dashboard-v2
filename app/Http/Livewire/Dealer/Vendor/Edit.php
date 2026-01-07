<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Vendor;

use App\Jobs\SendVendorEmailJob;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use WireElements\Pro\Components\SlideOver\SlideOver;

class Edit extends SlideOver
{
    public $vendor;
    public string $name = '';
    public string $email = '';
    protected $listeners = [
        'refreshVendorForms' => '$refresh',
        'vendorDeleted' => 'handleVendorDeleted',
    ];
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
    ];

    public function mount(Vendor $vendor): void
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

    public function handleVendorDeleted(int $vendorId): void
    {
        if ($this->vendor->id === $vendorId) {
            $this->close();
        }
    }

    public function render(): View
    {
        return view('livewire.dealer.vendor.edit', [
            'forms' => $this->vendor->forms()->latest()->with('emailLogs')->take(12)->get(),
            'stores' => Store::orderBy('name')->get(),
        ]);
    }

    private function createVendorForm(): VendorForm
    {
        return $this->vendor->forms()->create([
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }
}
