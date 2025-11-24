<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Dealer\CourseResults;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CourseResultsPolicy
{
    use HandlesAuthorization;

    public function resetCourses(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant', 'Qualified Individual']);
    }
}
