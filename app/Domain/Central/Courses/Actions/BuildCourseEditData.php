<?php

declare(strict_types=1);

namespace App\Domain\Central\Courses\Actions;

use App\Enums\State;
use App\Http\Resources\Central\CourseManagement\CourseEditResource;
use App\Models\Course;
use App\Models\Department;
use Spatie\Permission\Models\Role;

class BuildCourseEditData
{
    private const array EXCLUDED_ROLE_NAMES = ['super-admin', 'Admin', 'Consultant'];

    /**
     * @return array<string, mixed>
     */
    public function execute(Course $course): array
    {
        $course->load(['departments:id', 'roles:id']);

        return [
            'course' => new CourseEditResource($course)->resolve(),
            'options' => [
                'departments' => Department::query()
                    ->orderBy('name')
                    ->get(['id', 'name'])
                    ->map(fn (Department $d): array => ['value' => $d->id, 'label' => $d->name]),
                'roles' => Role::query()
                    ->whereNotIn('name', self::EXCLUDED_ROLE_NAMES)
                    ->orderBy('name')
                    ->get(['id', 'name'])
                    ->map(fn (Role $r): array => ['value' => $r->id, 'label' => $r->name]),
                'states' => collect(State::cases())
                    ->map(fn (State $s): array => ['value' => $s->label(), 'label' => $s->label()])
                    ->values(),
                'courses' => Course::query()
                    ->where('id', '!=', $course->id)
                    ->orderBy('name')
                    ->get(['slug', 'name'])
                    ->map(fn (Course $c): array => ['value' => $c->slug, 'label' => $c->name]),
            ],
        ];
    }
}
