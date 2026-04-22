<?php

declare(strict_types=1);

namespace App\Domain\Central\Courses\Data;

final readonly class CourseSettingsData
{
    /**
     * @param  array<int, int>  $department_ids
     * @param  array<int, int>  $role_ids
     * @param  array<int, string>  $states_required
     * @param  array<int, string>  $replaces_course_slugs
     */
    public function __construct(
        public array $department_ids,
        public array $role_ids,
        public array $states_required,
        public array $replaces_course_slugs,
    ) {}
}
