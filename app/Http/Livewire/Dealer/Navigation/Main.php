<?php

declare(strict_types=1);

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
    private static ?bool $cachedPhishingIsEnabled = null;

    public function mount(Request $request): void
    {
        $this->currentStore = $request->get('store');
        $this->phishingIsEnabled = static::$cachedPhishingIsEnabled ??= (bool) GlobalSetting::query()->first()?->phishing_active;

        $store = $this->currentStore ?? app('currentStoreModel') ?? Store::query()->first();
        $this->videosActive = $store?->videos ?? false;
    }

    public function render(): View
    {
        return view('livewire.dealer.navigation.main');
    }
}
