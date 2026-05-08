<?php

declare(strict_types=1);

namespace App\Http\Resources\Central;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @mixin Course
 */
class CourseIndexResource extends JsonResource
{
    #[Override]
    public function toArray(Request $request): array
    {
        $status = $this->resource->status();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'percentage' => $this->whenLoaded('latestUserResult', fn () => $this->latestUserResult?->percentage),
            'status' => [
                'label' => $status->label(),
                'color' => $status->color(),
            ],
        ];
    }
}
