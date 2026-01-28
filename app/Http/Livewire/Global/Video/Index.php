<?php

declare(strict_types=1);

namespace App\Http\Livewire\Global\Video;

use App\Services\VimeoService;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public $readyToLoad = false;
    public $isLoading = true;

    public function mount(): void
    {
        $this->isLoading = true;
    }

    public function loadVideos(): void
    {
        $this->readyToLoad = true;
        $this->isLoading = false;
    }

    public function render(): View
    {
        $videos = [];
        $categories = [];
        $videoProgressMap = [];

        if ($this->readyToLoad) {
            $vimeoService = app(VimeoService::class);
            $videos = collect($vimeoService->getVideos());
            $categories = $vimeoService->getCategories();

            // Load all video progress in one query
            if (auth()->check() && $videos->isNotEmpty()) {
                $videoIds = $videos->pluck('id')->toArray();
                $videoProgressMap = auth()->user()
                    ->videoProgress()
                    ->whereIn('video_id', $videoIds)
                    ->get()
                    ->keyBy('video_id')
                    ->toArray();
            }
        }

        return view('livewire.global.video.index', [
            'videos' => $videos,
            'categories' => $categories,
            'videoProgressMap' => $videoProgressMap,
        ])->layout($this->getLayout());
    }

    private function getLayout(): string
    {
        return tenancy()->initialized
            ? 'components.dealer-app'
            : 'layouts.app';
    }
}
