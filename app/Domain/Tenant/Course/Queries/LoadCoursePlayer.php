<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course\Queries;

use App\Concerns\BuildsVimeoEmbedUrl;
use App\Domain\Tenant\Course\Data\CoursePlayerData;
use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;
use App\Models\VideoProgress;
use App\Services\VimeoService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

class LoadCoursePlayer
{
    use BuildsVimeoEmbedUrl;

    public function __construct(
        private readonly CanIssueDotCertificate $canIssueDotCert,
    ) {}

    public function handle(Course $course, User $user, bool $fallbackToSlides = false): CoursePlayerData
    {
        $hasResults = $this->hasResults($course, $user);
        $videoCompleted = $this->videoCompleted($course, $user);
        $video = $fallbackToSlides ? null : $this->loadVideo($course, $videoCompleted, $hasResults);
        $slides = $video === null ? $this->loadSlides($course) : null;

        return new CoursePlayerData(
            course: [
                'id' => (int) $course->id,
                'name' => (string) $course->name,
                'slug' => (string) $course->slug,
            ],
            video: $video,
            slides: $slides,
            quizUrl: URL::temporarySignedRoute(
                'dealer.courses.quiz',
                now()->addMinutes(30),
                ['course' => $course->slug],
            ),
            videoCompleted: $videoCompleted,
            hasResults: $hasResults,
            canIssueDotCertificate: $this->canIssueDotCert->handle($user),
        );
    }

    /**
     * @return array{player_embed_url: string, title: string}|null
     */
    private function loadVideo(Course $course, bool $videoCompleted, bool $hasResults): ?array
    {
        if ($course->video_id === null || $course->video_id === '') {
            return null;
        }

        $video = resolve(VimeoService::class)->getVideo($course->video_id);
        if (! is_array($video) || ! isset($video['player_embed_url'])) {
            return null;
        }

        $parameters = ['dnt' => 1, 'playsinline' => 1];
        if (! $videoCompleted && ! $hasResults) {
            $parameters['progress_bar'] = 0;
        }

        $embedUrl = $this->buildVimeoEmbedUrl((string) $video['player_embed_url'], $parameters);

        if ($embedUrl === null) {
            return null;
        }

        return [
            'player_embed_url' => $embedUrl,
            'title' => (string) ($video['title'] ?? $course->name),
        ];
    }

    /**
     * @return list<array{title: string, description: string}>|null
     */
    private function loadSlides(Course $course): ?array
    {
        $slides = $course->slides;
        if (! is_array($slides) || $slides === []) {
            return null;
        }

        return array_values(array_map(static fn (array $slide): array => [
            'title' => (string) ($slide['title'] ?? ''),
            'description' => Blade::render(__((string) ($slide['description'] ?? ''))),
        ], $slides));
    }

    private function videoCompleted(Course $course, User $user): bool
    {
        if ($course->video_id === null || $course->video_id === '') {
            return false;
        }

        $latest = VideoProgress::query()
            ->where('user_id', $user->id)
            ->where('video_id', $course->video_id)
            ->latest()
            ->first();

        if ($latest === null) {
            return false;
        }

        return $latest->created_at->gt(now()->subYears((int) ($course->years_expires ?? 1)));
    }

    private function hasResults(Course $course, User $user): bool
    {
        return CourseResults::query()
            ->where('course_id', $course->id)
            ->where('user_id', $user->id)
            ->exists();
    }
}
