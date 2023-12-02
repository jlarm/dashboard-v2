<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Vendor;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $vendor;

    public function mount(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function delete()
    {
        try {
            $this->vendor->delete();

            $this->close();

            $this->emit('refreshVendors');

            Notification::make()
                ->title('Vendor Deleted Successfully')
                ->success()
                ->send();
        } catch (\Exception $e) {
            \Log::error($e);

            $this->addError('vendor', 'An error occurred while deleting the vendor.');

            Notification::make()
                ->title('There was an issue deleting the vendor.')
                ->danger()
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.dealer.vendor.delete');
    }
}
