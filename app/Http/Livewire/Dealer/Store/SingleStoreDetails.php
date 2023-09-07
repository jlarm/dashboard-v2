<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use Storage;

class SingleStoreDetails extends Component
{
    use WithFileUploads, WithMedia;

    public Store $store;
    public $dealer;
    public $name;
    public $address;
    public $city;
    public $state;
    public $postal_code;
    public $phone;
    public $website;
    public $mediaComponentNames = ['logo'];
    public $logo = null;
    public $active_monitoring = false;
    public $monitoring_start_date;

    protected $rules = [
        'name' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'postal_code' => 'required',
        'phone' => 'required',
        'website' => 'nullable',
        'active_monitoring' => 'boolean|required',
        'monitoring_start_date' => 'date|nullable',
    ];

    public function mount(): void
    {
        $this->dealer = Store::where('id', $this->store->id)->first();

        $this->name = $this->dealer->name;
        $this->address = $this->dealer->address;
        $this->city = $this->dealer->city;
        $this->state = $this->dealer->state;
        $this->postal_code = $this->dealer->postal_code;
        $this->phone = $this->dealer->phone;
        $this->website = $this->dealer->website;
        $this->active_monitoring = $this->dealer->active_monitoring;
        $this->monitoring_start_date = $this->dealer->monitoring_start_date?->format('Y-m-d');
    }

    public function updatedLogo(): void
    {
        $this->validate([
            'logo' => 'sometimes|image|max:1024', // 1MB Max
        ]);
    }


    public function update()
    {
        $this->validate();

//        if($this->logo) {
//            $this->logo = $this->logo->store('logo', 'public');
//        }

        try {
            $this->dealer->update([
                'name' => $this->name,
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
                'phone' => $this->phone,
                'website' => $this->website,
                'active_monitoring' => $this->active_monitoring,
                'monitoring_start_date' => $this->monitoring_start_date,
            ]);

            $this->dealer->syncFromMediaLibraryRequest($this->logo)
                ->toMediaCollection('logo', 'public');

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
