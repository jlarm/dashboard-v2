<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\ScanSetting;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Livewire\Component;

class Settings extends Component
{
    public Store $store;
    public $name;
    public $internalId;
    public $externalId;
    public $scan;
    protected $rules = [
        'name' => 'string|max:255',
        'internalId' => 'nullable|integer',
        'externalId' => 'nullable|integer',
    ];

    public function mount(): void
    {
        $this->store = Store::query()->find(resolve('currentStore'));
        $this->scan = ScanSetting::query()->find($this->store->id);
        $this->name = $this->scan->name ?? '';
        $this->internalId = $this->scan->internal_id ?? '';
        $this->externalId = $this->scan->external_id ?? '';
    }

    public function update(): Redirector|RedirectResponse
    {
        $this->validate();

        $this->scan->update([
            'name' => $this->name,
            'internal_id' => $this->internalId !== '' ? $this->internalId : null,
            'external_id' => $this->externalId !== '' ? $this->externalId : null,
        ]);

        Notification::make()
            ->title('Updated Successfully!')
            ->success()
            ->send();

        return redirect(route('dealer.scan.index'));
    }

    public function render(): View
    {
        return view('livewire.dealer.scan.settings');
    }
}
