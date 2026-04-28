<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Queries;

use App\Domain\Tenant\GlobalSettings\Data\CourseSettingData;
use App\Models\Dealer\Course;

class GetCourses
{
    /**
     * @return list<CourseSettingData>
     */
    public function handle(): array
    {
        return Course::query()
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'optional'])
            ->map(static fn (Course $course): CourseSettingData => CourseSettingData::fromModel($course))
            ->values()
            ->all();
    }
}
