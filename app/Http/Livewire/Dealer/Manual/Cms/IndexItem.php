<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Manual\Cms;

use App\Models\CmsManual;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public CmsManual $manual;
    public $link;

    public function mount(): void
    {
        $this->link = Storage::disk('do-manuals')->url(tenant('id').'/cms/'.$this->manual->pdf_path);
    }

    public function render(): View
    {
        return view('livewire.dealer.manual.cms.index-item');
    }
}
