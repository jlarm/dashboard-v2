<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function view(User $user, Course $course): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function manage(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    public function update(User $user, Course $course): bool
    {
        return $user->hasRole('super-admin');
    }

    public function import(User $user): bool
    {
        return $user->hasRole('super-admin');
    }
}
