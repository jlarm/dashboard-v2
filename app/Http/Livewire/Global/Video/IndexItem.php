<?php

declare(strict_types=1);

namespace App\Http\Livewire\Global\Video;

use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public $videoId;
    public $videoTitle;
    public $videoCategory;
    public $videoThumbnail;
    public $selectedCategory;
    public $videoProgress;

    public function getCurrentStoreProperty(): ?Store
    {
        if (! tenant()) {
            return null;
        }

        return Store::where('id', app('currentStore'))->first();
    }

    public function render(): View
    {
        return view('livewire.global.video.index-item');
    }
}
