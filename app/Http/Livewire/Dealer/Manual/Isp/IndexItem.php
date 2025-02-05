<?php

namespace App\Http\Livewire\Dealer\Manual\Isp;

use App\Models\Dealer\Manual\Isp;
use Illuminate\View\View;
use Livewire\Component;
use Storage;

class IndexItem extends Component
{
    public Isp $manual;

    public $link;

    public function mount(): void
    {
        $this->link = Storage::disk('do-manuals')->url(tenant('id').'/isp/'.$this->manual->pdf_path) ?? null;
    }

    public function render(): View
    {
        return view('livewire.dealer.manual.isp.index-item');
    }
}
