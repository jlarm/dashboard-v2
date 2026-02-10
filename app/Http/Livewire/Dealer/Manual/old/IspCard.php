<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Manual\old;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Bus;
use App\Jobs\Manuals\GenerateIspManualJob;
use App\Jobs\Manuals\UploadIspToDigitaloceanJob;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Store;
use Livewire\Component;

class IspCard extends Component
{
    public Store $store;
    public $manual;
    public $content;

    public function mount(): void
    {
        $this->manual = Isp::query()->where('store_id', $this->store->id)->latest()->first();
        if ($this->manual && $this->manual->pdf_path) {
            $this->content = Storage::disk('do-manuals')->url(tenant('id').'/isp/'.$this->manual->pdf_path) ?? null;
        }
    }

    public function generate(): void
    {
        Bus::chain([
            new GenerateIspManualJob($this->manual),
            new UploadIspToDigitaloceanJob($this->manual),
        ])->dispatch();
    }

    public function render()
    {
        return view('livewire.dealer.manual.isp-card');
    }
}
