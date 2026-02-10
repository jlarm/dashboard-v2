<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Manual\old;

use App\Jobs\Manuals\GenerateOshaManualJob;
use App\Jobs\Manuals\UploadOshaToDigitalOceanJob;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class OshaCard extends Component
{
    public Store $store;
    public $manual;
    public $content;

    public function mount(): void
    {
        $this->manual = Osha::query()->where('store_id', $this->store->id)->latest()->first();
        if ($this->manual && $this->manual->pdf_path) {
            $this->content = Storage::disk('do-manuals')->url(tenant('id').'/osha/'.$this->manual->pdf_path) ?? null;
        }
    }

    public function generate(): void
    {
        Bus::chain([
            new GenerateOshaManualJob($this->manual),
            new UploadOshaToDigitalOceanJob($this->manual),
        ])->dispatch();
    }

    public function render()
    {
        return view('livewire.dealer.manual.osha-card');
    }
}
