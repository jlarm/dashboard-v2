<?php

namespace App\Http\Livewire\Global\Video;

use App\Services\VimeoService;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public $readyToLoad = false;
    public $isLoading = true;
    
    public function mount()
    {
        $this->isLoading = true;
    }
    
    public function loadVideos()
    {
        $this->readyToLoad = true;
        $this->isLoading = false;
    }

    public function render(VimeoService $vimeoService): View
    {
        return view('livewire.global.video.index', [
            'videos' => $this->readyToLoad ? collect($vimeoService->getVideos()) : [],
            'categories' => $this->readyToLoad ? $vimeoService->getCategories() : [],
        ]);
    }
}
