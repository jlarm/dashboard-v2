<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Livewire\Component;

class Note extends Component
{
    public $note;
    public $store;

    public function mount()
    {
        $this->store = Store::where('id', app('currentStore'))->firstOrFail();
        $this->note = $this->store->note;
    }

    public function update()
    {
        $this->store->update([
            'note' => $this->note,
        ]);

        Notification::make()
            ->title('Note Updated Successfully!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.home.note');
    }
}
