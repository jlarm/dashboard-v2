<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Edit extends Modal
{
    public $vendor;
    public $name;
    public $contactName;
    public $contactEmail;
    public $store_id;

    public function rules()
    {
        return [
            'name' => 'required',
            'contactName' => 'required',
            'contactEmail' => 'required|email',
            'store_id' => 'nullable',
        ];
    }

    public function mount(Vendor $vendor)
    {
        $this->vendor = $vendor;
        $this->name = $vendor->name;
        $this->contactName = $vendor->contact_name;
        $this->contactEmail = $vendor->contact_email;
        $this->store_id = $vendor->store_id;
    }

    public function update()
    {
        $this->validate();
        $this->vendor->update([
            'name' => $this->name,
            'contact_name' => $this->contactName,
            'contact_email' => $this->contactEmail,
            'store_id' => $this->store_id,
        ]);

        $this->emit('refreshVendors');

        $this->close();

        Notification::make()
            ->title('Vendor Successfully Updated')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.vendor.edit',[
            'stores' => Store::orderBy('name')->get(),]);
    }
}
