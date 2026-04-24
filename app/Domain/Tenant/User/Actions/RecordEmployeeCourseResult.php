<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\User;
use Illuminate\Support\Carbon;

class RecordEmployeeCourseResult
{
    public function handle(User $user, Course $course, Carbon $takenOn): CourseResults
    {
        return CourseResults::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'passed' => 1,
            'percentage' => 100,
            'created_at' => $takenOn,
            'updated_at' => $takenOn,
        ]);
    }
}
