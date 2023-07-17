<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Scan;

use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Livewire\Component;

class Settings extends Component
{
    public Store $store;
    public $name;

    protected $rules = [
        'name' => 'string|max:255',
    ];

    public function mount()
    {
        $this->name = $this->store->scanSetting->name;
    }

    public function update()
    {
        $this->validate();

        $this->store->scanSetting()->update([
            'name' => $this->name,
        ]);

        Notification::make()
            ->title('Updated Successfully!')
            ->success()
            ->send();

        if(tenant('locations')) {
            return redirect()->route('dealer.stores.scans', $this->store);
        } else {
            return redirect()->route('dealer.scan.index');
        }
    }

    public function render()
    {
        return view('livewire.dealer.store.single-store.scan.settings');
    }
}
