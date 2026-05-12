<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course\Data;

class CoursePlayerData
{
    /**
     * @param  array{id: int, name: string, slug: string}  $course
     * @param  array{player_embed_url: string, title: string}|null  $video
     * @param  list<array{title: string, description: string}>|null  $slides
     */
    public function __construct(
        public readonly array $course,
        public readonly ?array $video,
        public readonly ?array $slides,
        public readonly string $quizUrl,
        public readonly bool $videoCompleted,
        public readonly bool $hasResults,
        public readonly bool $canIssueDotCertificate,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'course' => $this->course,
            'video' => $this->video,
            'slides' => $this->slides,
            'quiz_url' => $this->quizUrl,
            'video_completed' => $this->videoCompleted,
            'has_results' => $this->hasResults,
            'can_issue_dot_certificate' => $this->canIssueDotCertificate,
        ];
    }
}
