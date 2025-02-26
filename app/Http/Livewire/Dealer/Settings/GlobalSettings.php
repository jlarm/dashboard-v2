<?php

namespace App\Http\Livewire\Dealer\Settings;

use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Livewire\Component;

class GlobalSettings extends Component
{
    public $settings;

    public $phishing_active;

    public $phishing_token;

    public $phishing_ip;

    public $stores = [];

    public function mount()
    {
        $this->settings = GlobalSetting::first();

        $this->phishing_active = $this->settings->phishing_active ?? false;
        $this->phishing_token = $this->settings->phishing_token ?? null;
        $this->phishing_ip = $this->settings->phishing_ip ?? null;

        $this->stores = Store::query()->orderBy('name')->select(['id', 'name', 'courses_not_taken_notification'])->get();
    }

    public function toggleStoreNotifications($storeId): void
    {
        $store = Store::find($storeId);
        
        if ($store) {
            $store->update([
                'courses_not_taken_notification' => !$store->courses_not_taken_notification
            ]);
            
            // Refresh the stores list
            $this->stores = Store::query()->orderBy('name')->select(['id', 'name', 'courses_not_taken_notification'])->get();
        }
    }

    public function update()
    {
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

        Notification::make()
            ->title('Settings Updated Successfully!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.settings.global-settings')->layout('components.dealer-app');
    }
}
