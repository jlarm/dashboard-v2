<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

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

    public $phishing_active = false;

    public $phishing_token;

    public $phishing_ip;

    public $monitoring_start_date;

    public $settings;

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
        'phishing_active' => 'boolean|required',
        'phishing_token' => 'nullable|string',
        'phishing_ip' => 'nullable|string',
    ];

    public function mount(): void
    {
        $this->dealer = Store::where('id', $this->store->id)->first();
        $this->settings = GlobalSetting::first();

        $this->name = $this->dealer->name;
        $this->address = $this->dealer->address;
        $this->city = $this->dealer->city;
        $this->state = $this->dealer->state;
        $this->postal_code = $this->dealer->postal_code;
        $this->phone = $this->dealer->phone;
        $this->website = $this->dealer->website;
        $this->active_monitoring = $this->dealer->active_monitoring;
        $this->monitoring_start_date = $this->dealer->monitoring_start_date?->format('Y-m-d');
        $this->phishing_active = $this->settings->phishing_active;
        $this->phishing_token = $this->settings->phishing_token ?? null;
        $this->phishing_ip = $this->settings->phishing_ip ?? null;
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

            if (is_null($this->settings)) {
                GlobalSetting::create([
                    'phishing_active' => $this->phishing_active,
                    'phishing_token' => $this->phishing_token,
                    'phishing_ip' => $this->phishing_ip,
                ]);
            } else {
                $this->settings->update([
                    'phishing_active' => $this->phishing_active,
                    'phishing_token' => $this->phishing_token,
                    'phishing_ip' => $this->phishing_ip,
                ]);
            }

            $this->dealer->syncFromMediaLibraryRequest($this->logo)
                ->toMediaCollection('logo', 'digitalocean');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
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
        if ($this->dealer->logo) {
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
