<?php

declare(strict_types=1);

namespace App\Policies\Central;

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
            && ! $model->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function delete(User $user, User $model): bool
    {
        return $user->can('create-stores')
            && $user->id !== $model->id
            && ! $model->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function impersonate(User $user, User $model): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant'])
            && $user->id !== $model->id
            && ! $model->hasRole('super-admin');
    }

    public function recordCourseResult(User $user, User $model): bool
    {
        return $user->can('create-dealerships') && $user->id !== $model->id;
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
