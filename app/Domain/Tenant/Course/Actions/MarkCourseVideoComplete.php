<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course\Actions;

use App\Models\Dealer\Course;
use App\Models\User;
use App\Models\VideoProgress;

class MarkCourseVideoComplete
{
    public function handle(Course $course, User $user): void
    {
        if ($course->video_id === null || $course->video_id === '') {
            return;
        }

        VideoProgress::query()->create([
            'user_id' => $user->id,
            'video_id' => $course->video_id,
            'completed' => true,
        ]);
    }
}
