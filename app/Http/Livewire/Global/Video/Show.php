<?php

declare(strict_types=1);

namespace App\Http\Livewire\Global\Video;

use App\Models\VideoProgress;
use App\Services\VimeoService;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class Show extends Component
{
    public string $videoId;

    #[Override]
    protected $listeners = [
        'completedVideo' => 'completedVideo',
        'refresh' => 'videoCompleted',
    ];

    public function mount(string $videoId): void
    {
        $this->videoId = $videoId;
    }

    public function completedVideo(): void
    {
        VideoProgress::query()->updateOrCreate([
            'user_id' => auth()->id(),
            'video_id' => $this->videoId,
        ], [
            'completed' => true,
        ]);

        $this->dispatch('refresh');
    }

    public function videoCompleted(): bool
    {
        $status = auth()->user()->videoProgress()->where('video_id', $this->videoId)->first();

        return $status && $status->completed;
    }

    public function render(VimeoService $vimeoService): View
    {
        return view('livewire.global.video.show', [
            'video' => $vimeoService->getVideo($this->videoId),
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
