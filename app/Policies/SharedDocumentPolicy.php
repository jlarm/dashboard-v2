<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\SharedDocument;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SharedDocumentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    public function update(User $user, SharedDocument $sharedDocument): bool
    {
        return $user->hasRole('super-admin');
    }

    public function delete(User $user, SharedDocument $sharedDocument): bool
    {
        return $user->hasRole('super-admin');
    }
}
