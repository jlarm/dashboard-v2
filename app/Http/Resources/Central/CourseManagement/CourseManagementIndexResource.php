<?php

declare(strict_types=1);

namespace App\Http\Resources\Central\CourseManagement;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @mixin Course
 */
class CourseManagementIndexResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'has_video' => ! empty($this->video_id),
        ];
    }
}
