<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Log\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\Activitylog\Models\Activity;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class ActivityLogData implements Arrayable
{
    /**
     * @param  array<string, mixed>  $properties
     */
    public function __construct(
        public int $id,
        public ?string $event,
        public ?string $description,
        public ?string $subjectType,
        public int|string|null $subjectId,
        public ?string $causerName,
        public ?string $createdAt,
        public ?string $createdAtDiff,
        public ?string $createdAtHuman,
        public array $properties,
    ) {}

    public static function fromModel(Activity $activity): self
    {
        return new self(
            id: (int) $activity->id,
            event: $activity->event,
            description: $activity->description,
            subjectType: $activity->subject_type !== null ? class_basename($activity->subject_type) : null,
            subjectId: $activity->subject_id,
            causerName: $activity->causer?->name,
            createdAt: $activity->created_at?->toIso8601String(),
            createdAtDiff: $activity->created_at?->diffForHumans(),
            createdAtHuman: $activity->created_at?->format('F j, Y \a\t g:i A'),
            properties: $activity->properties?->toArray() ?? [],
        );
    }

    /**
     * @return array{
     *     id: int,
     *     event: string|null,
     *     description: string|null,
     *     subject_type: string|null,
     *     subject_id: int|string|null,
     *     causer_name: string|null,
     *     created_at: string|null,
     *     created_at_diff: string|null,
     *     created_at_human: string|null,
     *     properties: array<string, mixed>
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'event' => $this->event,
            'description' => $this->description,
            'subject_type' => $this->subjectType,
            'subject_id' => $this->subjectId,
            'causer_name' => $this->causerName,
            'created_at' => $this->createdAt,
            'created_at_diff' => $this->createdAtDiff,
            'created_at_human' => $this->createdAtHuman,
            'properties' => $this->properties,
        ];
    }
}
