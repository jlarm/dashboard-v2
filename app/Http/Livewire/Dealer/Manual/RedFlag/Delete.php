<?php

namespace App\Http\Livewire\Dealer\Manual\RedFlag;

use App\Models\Dealer\Manual\RedFlag;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $manual;

    public function mount(RedFlag $manual): void
    {
        $this->manual = $manual;
    }

    public function delete(): void
    {
        if ($this->manual->pdf_path) {
            Storage::disk('do-manuals')->delete(tenant('id').'/red-flags/'.$this->manual->pdf_path);
        }

        Storage::delete('red-flag-signatures/'.$this->manual->signature);

        $this->manual->delete();

        $this->close();

        $this->emit('$refresh');

        Notification::make()
            ->title('Manual Deleted')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.dealer.manual.red-flag.delete');
    }
}
