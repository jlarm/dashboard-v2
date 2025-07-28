<?php

namespace App\Http\Livewire\Dealer\Navigation;

use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Livewire\Component;

class Main extends Component
{
    public $currentStore;

    public $phishingIsEnabled;

    public $videosActive;

    public function mount(Request $request): void
    {
        $this->currentStore = Store::where('name', $request->get('store')?->name)->first();
        $this->phishingIsEnabled = GlobalSetting::first()->phishing_active ?? null;
        $this->videosActive = $this->getVideoStatus();
    }

    public function render(): View
    {
        return view('livewire.dealer.navigation.main');
    }

    private function getVideoStatus(): bool
    {
        $store = Store::first();

        if (! $store) {
            return false;
        }

        if ($this->currentStore) {
            return $this->currentStore->videos;
        }

        return $store->videos;
    }
}
