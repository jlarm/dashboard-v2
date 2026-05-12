<?php

declare(strict_types=1);

namespace App\Policies\Central;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Super-admin access is granted globally via Gate::before in AppServiceProvider.
 * Tenant visibility (department/store scoping) is enforced at the query layer via
 * GetEmployees::isVisibleTo, so `view` stays denied here.
 */
class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, User $model): bool
    {
        return false;
    }

    public function viewDeleted(User $user): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, User $model): bool
    {
        return $user->can('create-stores')
            && $user->id !== $model->id
            && ! $model->hasAnyRole([Role::SuperAdmin->value, Role::Consultant->value]);
    }

    public function delete(User $user, User $model): bool
    {
        return $user->can('create-stores')
            && $user->id !== $model->id
            && ! $model->hasAnyRole([Role::SuperAdmin->value, Role::Consultant->value]);
    }

    public function impersonate(User $user, User $model): bool
    {
        return $user->hasAnyRole([Role::SuperAdmin->value, Role::Consultant->value])
            && $user->id !== $model->id
            && ! $model->hasRole(Role::SuperAdmin->value);
    }

    public function recordCourseResult(User $user, User $model): bool
    {
        return $user->can('create-dealerships') && $user->id !== $model->id;
    }

    public function manageCourses(User $user, User $model): bool
    {
        return $user->hasAnyRole([
            Role::SuperAdmin->value,
            Role::Consultant->value,
            Role::QualifiedIndividual->value,
        ]) && $user->id !== $model->id;
    }

    public function generateDotCertificate(User $user, User $model): bool
    {
        return $user->can('create-dealerships') && $user->id !== $model->id;
    }

    public function selfIssueDotCertificate(User $user): bool
    {
        return $user->exists;
    }

    public function restore(User $user, User $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
