<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;

class Note extends Component
{
    public ?string $note = null;
    public Store $store;

    public function mount(): void
    {
        $this->store = Store::where('id', app('currentStore'))->firstOrFail();
        $this->note = $this->store->note;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'note' => ['nullable', 'string', 'max:65535'],
        ]);

        $this->store->update($validated);

        Notification::make()
            ->title('Note Updated Successfully!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.dealer.home.note');
    }
}
