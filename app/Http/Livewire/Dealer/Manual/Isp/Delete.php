<?php

namespace App\Http\Livewire\Dealer\Manual\Isp;

use App\Models\Dealer\Manual\Isp;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $manual;

    public function mount(Isp $manual): void
    {
        $this->manual = $manual;
    }

    public function delete(): void
    {
        if ($this->manual->pdf_path) {
            Storage::disk('do-manuals')->delete(tenant('id').'/isp/' . $this->manual->pdf_path);
        }

        Storage::delete('isp-signatures/' . $this->manual->signature);

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
        return view('livewire.dealer.manual.isp.delete');
    }
}
