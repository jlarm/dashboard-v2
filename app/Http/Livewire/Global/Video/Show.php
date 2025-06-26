<?php

namespace App\Http\Livewire\Global\Video;

use App\Models\VideoProgress;
use App\Services\VimeoService;
use Illuminate\View\View;
use Livewire\Component;

class Show extends Component
{
    public string $videoId;

    protected $listeners = [
        'completedVideo' => 'completedVideo',
        'refresh' => 'videoCompleted'
    ];

    public function mount($videoId): void
    {
        $this->videoId = $videoId;
    }

    public function completedVideo(): void
    {
        VideoProgress::updateOrCreate([
            'user_id' => auth()->id(),
            'video_id' => $this->videoId,
        ], [
            'completed' => true,
        ]);

        $this->emit('refresh');
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
