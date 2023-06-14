<?php

namespace App\Http\Livewire\Dealer\Manual;

use App\Jobs\Manuals\GenerateRedFlagManualJob;
use App\Jobs\Manuals\UploadRedFlagToDigitalOceanJob;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use Livewire\Component;
use Storage;

class RedFlagCard extends Component
{
    public Store $store;

    public $manual;
    public $content;

    public function mount()
    {
        $this->manual = RedFlag::latest()->first();
        if($this->manual && $this->manual->pdf_path) {
            $this->content = Storage::disk('do-manuals')->url(tenant('id') . '/red-flags/' . $this->manual->pdf_path) ?? null;
        }
    }

    public function generate()
    {
        \Bus::chain([
            new GenerateRedFlagManualJob($this->manual),
            new UploadRedFlagToDigitalOceanJob($this->manual),
        ])->dispatch();
    }

    public function render()
    {
        return view('livewire.dealer.manual.red-flag-card');
    }
}
