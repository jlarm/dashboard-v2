<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;

class SingleStoreDetails extends Component
{
    use WithFileUploads;

    public $store;
    public $dealer;
    public $name;
    public $address;
    public $city;
    public $state;
    public $postal_code;
    public $phone;
    public $website;
    public $logo;

    protected $rules = [
        'name' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'postal_code' => 'required',
        'phone' => 'required',
        'website' => 'required',
        'logo' => 'nullable|image|max:1024|mimes:png,jpg',
    ];

    public function mount(Store $store): void
    {
        if ($store->id) {
            $this->dealer = Store::where('id', $this->store->id)->first();
        } else {
            $this->dealer = Store::first();
        }

        $this->name = $this->dealer->name;
        $this->address = $this->dealer->address;
        $this->city = $this->dealer->city;
        $this->state = $this->dealer->state;
        $this->postal_code = $this->dealer->postal_code;
        $this->phone = $this->dealer->phone;
        $this->website = $this->dealer->website;
        $this->logo = $this->dealer->logo;
    }

    public function updatedLogo(): void
    {
        $this->validate([
            'logo' => 'nullable|image|max:1024|mimes:png,jpg', // 1MB Max
        ]);
    }


    public function update()
    {
        $this->validate();

        if($this->logo != null) {
            $this->logo = $this->logo->store('logo', 'public');
        }

        try {
            $this->dealer->update([
                'name' => $this->name,
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
                'phone' => $this->phone,
                'website' => $this->website,
                'logo' => $this->logo,
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            Notification::make()
                ->title('Something went wrong!')
                ->danger()
                ->send();
        }

        Notification::make()
            ->title('Settings Updated Successfully!')
            ->success()
            ->send();

    }

    public function deleteLogo()
    {
        if($this->dealer->logo) {
            Storage::delete($this->dealer->logo);
        }

        $this->dealer->update([
            'logo' => null,
        ]);

        return redirect()->route('dealer.dealer.settings');
    }

    public function render()
    {
        return view('livewire.dealer.store.single-store-details');
    }
}
