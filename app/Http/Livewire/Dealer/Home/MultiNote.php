<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Livewire\Component;

class MultiNote extends Component
{
    public Store $store;
    public $note;

    public function mount()
    {
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
        return view('livewire.dealer.home.multi-note');
    }
}
