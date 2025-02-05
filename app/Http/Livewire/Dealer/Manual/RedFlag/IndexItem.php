<?php

namespace App\Http\Livewire\Dealer\Manual\RedFlag;

use App\Models\Dealer\Manual\RedFlag;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public RedFlag $manual;

    public $link;

    public function mount(): void
    {
        $this->link = Storage::disk('do-manuals')
            ->url(tenant('id').'/red-flags/'.$this->manual->pdf_path) ?? null;
    }

    public function render(): View
    {
        return view('livewire.dealer.manual.red-flag.index-item');
    }
}
