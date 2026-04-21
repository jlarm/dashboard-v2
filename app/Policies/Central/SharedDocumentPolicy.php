<?php

declare(strict_types=1);

namespace App\Policies\Central;

use App\Models\SharedDocument;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SharedDocumentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function view(User $user, SharedDocument $document): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    public function delete(User $user): bool
    {
        return $user->hasRole('super-admin');
    }
}
