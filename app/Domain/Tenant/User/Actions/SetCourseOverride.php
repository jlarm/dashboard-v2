<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Domain\Tenant\User\Queries\GetEmployees;
use App\Models\Dealer\Course;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SetCourseOverride
{
    public function handle(User $actor, User $target, Course $course, string $state): void
    {
        DB::transaction(function () use ($actor, $target, $course, $state): void {
            $target->courses()->detach($course->id);

            if ($state === 'add' || $state === 'exclude') {
                $target->courses()->attach($course->id, [
                    'type' => $state,
                    'assigned_by' => $actor->id,
                ]);
            }
        });

        $target->clearCourseCache();
        GetEmployees::bustTrainingCounts();
    }
}
