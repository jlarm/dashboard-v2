<?php

namespace App\Http\Livewire\Dealer\Manual\Osha;

use App\Models\Dealer\Manual\Osha;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class IndexItem extends Component
{
    public Osha $manual;

    public $link;

    public function mount()
    {
        $this->link = Storage::disk('do-manuals')->url(tenant('id') . '/osha/' . $this->manual->pdf_path) ?? null;
    }

    public function render()
    {
        return view('livewire.dealer.manual.osha.index-item');
    }
}
