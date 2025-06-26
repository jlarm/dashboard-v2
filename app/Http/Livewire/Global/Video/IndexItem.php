<?php

namespace App\Http\Livewire\Global\Video;

use App\Models\Dealer\Store;
use App\Models\VideoProgress;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public $currentStore;
    public string $videoId;
    public string $videoTitle;
    public string $videoCategory;
    public string $videoThumbnail;
    public string $selectedCategory;
    public ?VideoProgress $videoProgress;

    public function mount(): void
    {
        $this->currentStore = Store::where('id', app('currentStore'))->first();
    }

    public function render(): View
    {
        return view('livewire.global.video.index-item');
    }
}
