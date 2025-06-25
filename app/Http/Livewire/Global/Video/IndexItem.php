<?php

namespace App\Http\Livewire\Global\Video;

use App\Models\VideoProgress;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public string $videoId;
    public string $videoTitle;
    public string $videoCategory;
    public string $videoThumbnail;
    public string $selectedCategory;
    public ?VideoProgress $videoProgress;

    public function mount(): void
    {
        $this->videoProgress = auth()->user()->videoProgress()->where('video_id', $this->videoId)->first() ?? null;
    }

    public function render(): View
    {
        return view('livewire.global.video.index-item');
    }
}
