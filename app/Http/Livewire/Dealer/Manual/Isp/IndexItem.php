<?php

namespace App\Http\Livewire\Dealer\Manual\Isp;

use App\Models\Dealer\Manual\Isp;
use Livewire\Component;
use Storage;

class IndexItem extends Component
{
    public Isp $manual;

    public $link;

    public function mount()
    {
        $this->link = Storage::disk('do-manuals')->url(tenant('id').'/isp/'.$this->manual->pdf_path) ?? null;
    }

    public function render()
    {
        return view('livewire.dealer.manual.isp.index-item');
    }
}
