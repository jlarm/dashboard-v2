<?php

declare(strict_types=1);

namespace App\Domain\Central\Courses\Actions;

use App\Domain\Central\Courses\Data\CourseQuizData;
use App\Models\Course;
use App\Models\Dealer\Course as TenantCourse;
use App\Models\Dealership;
use Illuminate\Database\Eloquent\Collection;

class UpdateCourseQuiz
{
    public function handle(Course $course, CourseQuizData $data): Course
    {
        $attributes = ['questions' => $data->questions];

        tenancy()->central(function () use ($course, $attributes): void {
            $course->update($attributes);

            Dealership::query()->chunkById(50, function (Collection $tenants) use ($course, $attributes): void {
                foreach ($tenants as $tenant) {
                    /** @var Dealership $tenant */
                    tenancy()->initialize($tenant);

                    TenantCourse::query()
                        ->where('slug', $course->slug)
                        ->update($attributes);

                    tenancy()->end();
                }
            });
        });

        return $course->refresh();
    }
}
