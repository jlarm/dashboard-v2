<?php

namespace App\Http\Livewire\Global\Video;

use App\Services\VimeoService;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(VimeoService $vimeoService): View
    {
        $collection = collect($vimeoService->getVideos());

        return view('livewire.global.video.index', [
            'videos' => $collection,
            'categories' => $vimeoService->getCategories(),
        ]);
    }
}
