<?php

declare(strict_types=1);

namespace App\Http\Resources\Central\CourseManagement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

class CourseEditResource extends JsonResource
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
            'video_id' => $this->video_id,
            'slides' => $this->slides ?? [],
            'questions' => $this->questions ?? [],
            'states_required' => $this->states_required ?? [],
            'replaces_course_slugs' => $this->replaces_course_slugs ?? [],
            'department_ids' => $this->whenLoaded(
                'departments',
                fn () => $this->departments->pluck('id')->all(),
                fn () => $this->resource->departments()->pluck('departments.id')->all(),
            ),
            'role_ids' => $this->whenLoaded(
                'roles',
                fn () => $this->roles->pluck('id')->all(),
                fn () => $this->resource->roles()->pluck('roles.id')->all(),
            ),
        ];
    }
}
