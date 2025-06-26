<?php

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

    public function render(VimeoService $vimeoService): View
    {
        return view('livewire.global.video.index', [
            'videos' => $this->readyToLoad ? collect($vimeoService->getVideos()) : [],
            'categories' => $this->readyToLoad ? $vimeoService->getCategories() : [],
        ])->layout($this->layout());
    }

    private function layout(): string
    {
        if (tenancy()->initialized) {
            return 'components.dealer-app';
        }

        return 'layouts.app';
    }
}
