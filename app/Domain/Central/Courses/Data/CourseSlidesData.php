<?php

declare(strict_types=1);

namespace App\Domain\Central\Courses\Data;

final readonly class CourseSlidesData
{
    /**
     * @param  array<int, array{title: ?string, description: ?string}>  $slides
     */
    public function __construct(
        public string $name,
        public ?string $video_id,
        public array $slides,
    ) {}
}
