<?php

namespace App\Http\Livewire\Dealer\Manual\Cms;

use App\Models\CmsManual;
use Livewire\Component;
use Storage;

class IndexItem extends Component
{
    public CmsManual $manual;

    public $link;

    public function mount()
    {
        $this->link = Storage::disk('do-manuals')->url(tenant('id').'/cms/'.$this->manual->pdf_path) ?? null;
    }

    public function render()
    {
        return view('livewire.dealer.manual.cms.index-item');
    }
}
