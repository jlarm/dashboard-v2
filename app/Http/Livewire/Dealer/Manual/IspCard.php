<?php

namespace App\Http\Livewire\Dealer\Manual;

use App\Jobs\Manuals\GenerateIspManualJob;
use App\Jobs\Manuals\UploadIspToDigitaloceanJob;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Store;
use Livewire\Component;
use Storage;

class IspCard extends Component
{
    public Store $store;
    public $manual;
    public $content;

    public function mount()
    {
        $this->manual = Isp::latest()->first();
        if($this->manual && $this->manual->pdf_path) {
            $this->content = Storage::disk('do-manuals')->url(tenant('id') . '/isp/' . $this->manual->pdf_path) ?? null;
        }
    }

    public function generate()
    {
        \Bus::chain([
            new GenerateIspManualJob($this->manual),
            new UploadIspToDigitaloceanJob($this->manual),
        ])->dispatch();
    }

    public function render()
    {
        return view('livewire.dealer.manual.isp-card');
    }
}
