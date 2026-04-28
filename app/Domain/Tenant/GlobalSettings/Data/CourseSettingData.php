<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Data;

use App\Models\Dealer\Course;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class CourseSettingData implements Arrayable
{
    public function __construct(
        public int $id,
        public string $name,
        public string $slug,
        public bool $optional,
    ) {}

    public static function fromModel(Course $course): self
    {
        return new self(
            id: (int) $course->id,
            name: (string) $course->name,
            slug: (string) $course->slug,
            optional: (bool) $course->optional,
        );
    }

    /**
     * @return array{id: int, name: string, slug: string, optional: bool}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'optional' => $this->optional,
        ];
    }
}
