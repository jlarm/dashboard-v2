<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Manual\old;

use App\Jobs\Manuals\GenerateRedFlagManualJob;
use App\Jobs\Manuals\UploadRedFlagToDigitalOceanJob;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class RedFlagCard extends Component
{
    public Store $store;
    public $manual;
    public $content;

    public function mount(): void
    {
        $this->manual = RedFlag::query()->where('store_id', $this->store->id)->latest()->first();
        if ($this->manual && $this->manual->pdf_path) {
            $this->content = Storage::disk('do-manuals')->url(tenant('id').'/red-flags/'.$this->manual->pdf_path) ?? null;
        }
    }

    public function generate(): void
    {
        Bus::chain([
            new GenerateRedFlagManualJob($this->manual),
            new UploadRedFlagToDigitalOceanJob($this->manual),
        ])->dispatch();
    }

    public function render()
    {
        return view('livewire.dealer.manual.red-flag-card');
    }
}
