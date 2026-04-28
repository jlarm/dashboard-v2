<?php

declare(strict_types=1);

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;
use Spatie\Activitylog\Models\Activity;

/**
 * @mixin Activity
 */
class ActivityLogResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'event' => $this->event,
            'description' => $this->description,
            'subject_type' => $this->subject_type !== null ? class_basename($this->subject_type) : null,
            'subject_id' => $this->subject_id,
            'causer_name' => $this->causer?->name,
            'created_at' => $this->created_at?->toIso8601String(),
            'created_at_diff' => $this->created_at?->diffForHumans(),
            'created_at_human' => $this->created_at?->format('F j, Y \a\t g:i A'),
            'properties' => $this->properties?->toArray() ?? [],
        ];
    }
}
