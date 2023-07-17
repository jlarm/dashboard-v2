<?php

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\ScanSetting;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Livewire\Component;

class Settings extends Component
{
    public $name;
    public Store $store;

    public function getScanProperty()
    {
        return ScanSetting::first();
    }

    public function mount()
    {
        $this->name = $this->scan->name ?? '';
    }

    protected $rules = [
        'name' => 'string|max:255',
    ];

    public function update()
    {
        $this->validate();

        $this->scan->update([
            'name' => $this->name,
        ]);

        Notification::make()
            ->title('Updated Successfully!')
            ->success()
            ->send();

        if(tenant('locations')){
            return redirect(route('dealer.stores.scans', $this->store));
        } else {
            return redirect(route('dealer.scan.index'));
        }


    }
    public function render()
    {
        return view('livewire.dealer.scan.settings');
    }
}
