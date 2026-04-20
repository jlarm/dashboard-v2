<?php

declare(strict_types=1);

namespace App\Domain\Central\Courses\Actions;

use App\Concerns\BuildsVimeoEmbedUrl;
use App\Models\Course;
use App\Models\VideoProgress;
use App\Services\VimeoService;
use Illuminate\Support\Facades\URL;

class BuildCourseShowData
{
    use BuildsVimeoEmbedUrl;

    public function __construct(private readonly VimeoService $vimeoService) {}

    public function execute(Course $course): array
    {
        $video = $course->video_id
            ? $this->vimeoService->getVideo($course->video_id)
            : null;

        if ($video === null && is_string($course->video_id) && $course->video_id !== '') {
            $video = $this->vimeoService->getVideo($course->video_id, fresh: true);
        }

        $videoCompleted = $this->isVideoCompleted($course);

        return [
            'player_embed_url' => $this->buildPlayerEmbedUrl($video, $videoCompleted),
            'video_completed' => $videoCompleted,
            'quiz_link' => URL::temporarySignedRoute('courses.quiz', now()->addMinutes(30), ['course' => $course->slug]),
            'slides' => $course->slides ?? [],
        ];
    }

    private function isVideoCompleted(Course $course): bool
    {
        if (! $course->video_id) {
            return false;
        }

        $latestProgress = VideoProgress::query()
            ->where('user_id', auth()->id())
            ->where('video_id', $course->video_id)
            ->latest()
            ->first();

        return $latestProgress !== null;
    }

    private function buildPlayerEmbedUrl(?array $video, bool $videoCompleted): ?string
    {
        $parameters = [
            'dnt' => 1,
            'playsinline' => 1,
        ];

        if (! $videoCompleted) {
            $parameters['progress_bar'] = 0;
        }

        return $this->buildVimeoEmbedUrl($video['player_embed_url'] ?? null, $parameters);
    }
}
