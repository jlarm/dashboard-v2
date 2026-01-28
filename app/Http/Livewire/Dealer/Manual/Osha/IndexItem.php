<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Manual\Osha;

use App\Models\Dealer\Manual\Osha;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public Osha $manual;
    public $link;

    public function mount(): void
    {
        $this->link = Storage::disk('do-manuals')->url(tenant('id').'/osha/'.$this->manual->pdf_path) ?? null;
    }

    public function render(): View
    {
        return view('livewire.dealer.manual.osha.index-item');
    }
}
