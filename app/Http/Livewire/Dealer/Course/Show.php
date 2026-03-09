<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Course;

use App\Http\Livewire\Concerns\BuildsVimeoEmbedUrl;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\VideoProgress;
use App\Services\VimeoService;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Livewire\Component;

class Show extends Component
{
    use BuildsVimeoEmbedUrl;

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
            'dealer.courses.quiz',
            now()->addMinutes(30),
            ['course' => $this->course->slug]
        );
    }

    public function markVideoCompleted(): void
    {
        VideoProgress::query()->create([
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
            $this->showSlidesFallback();
        }
    }

    public function hasCourseResults(): bool
    {
        return CourseResults::query()
            ->where('user_id', auth()->id())
            ->where('course_id', $this->course->id)
            ->exists();
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

        return view('livewire.dealer.course.show', ['quizLink' => $quizLink]);
    }

    public function playerEmbedUrl(): ?string
    {
        $parameters = [
            'dnt' => 1,
            'playsinline' => 1,
        ];

        if (! $this->videoCompleted() && ! $this->hasCourseResults()) {
            $parameters['progress_bar'] = 0;
        }

        return $this->buildVimeoEmbedUrl($this->video['player_embed_url'] ?? null, $parameters);
    }

    private function initializeContent(): void
    {
        if ($this->course->video_id) {
            $this->video = $this->getVimeoVideo();
        } else {
            $this->slides = collect($this->course->slides)->toArray();
        }
    }

    private function getVimeoVideo(): ?array
    {
        return app(VimeoService::class)->getVideo($this->course->video_id);
    }
}
