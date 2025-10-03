<?php

namespace App\Http\Livewire\Central\Course;

use App\Models\Course;
use App\Models\VideoProgress;
use App\Services\VimeoService;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Livewire\Component;

class Show extends Component
{
    public Course $course;
    public ?array $slides = null;
    public ?array $video = null;
    public bool $showSlidesFallback = false;
    public int $videoRetryCount = 0;
    protected $listeners = ['markVideoCompleted', 'showSlidesFallback', 'retryVideoLoad'];

    public function mount(): void
    {
        $this->initializeContent();
    }

    public function quizLink(): string
    {
        return URL::temporarySignedRoute(
            'courses.quiz',
            now()->addMinutes(30),
            ['course' => $this->course->slug]
        );
    }

    public function markVideoCompleted(): void
    {
        VideoProgress::create([
            'user_id' => auth()->id(),
            'video_id' => $this->course->video_id,
            'completed' => true,
        ]);

        $this->emit('refresh');
    }

    public function showSlidesFallback(): void
    {
        $this->showSlidesFallback = true;
        $this->slides = collect($this->course->slides)->toArray();
    }

    public function retryVideoLoad(): void
    {
        $this->videoRetryCount++;

        // Refresh video data from Vimeo (gets fresh privacy hash)
        $this->video = $this->getVimeoVideo();

        if (! $this->video) {
            // If still failing, force slides fallback
            $this->showSlidesFallback();
        }
    }

    public function videoCompleted(): bool
    {
        $latestProgress = auth()->user()->videoProgress()->where('video_id', $this->course->video_id)->latest()->first();

        if (! $latestProgress) {
            return false;
        }

        $cutOffDate = now()->subYears($this->course->years_expires ?? 1);

        return $latestProgress->created_at->gt($cutOffDate);
    }

    public function render(): View
    {
        $quizLink = $this->quizLink();

        return view('livewire.central.course.show', compact('quizLink'));
    }

    private function initializeContent(): void
    {
        if ($this->course->video_id) {
            $this->video = $this->getVimeoVideo();
        } else {
            $this->slides = collect($this->course->slides)->toArray();
        }
    }

    private function getVimeoVideo(): array
    {
        return (new VimeoService())->getVideo($this->course->video_id);
    }
}
