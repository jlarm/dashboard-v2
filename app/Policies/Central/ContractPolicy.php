<?php

declare(strict_types=1);

namespace App\Policies\Central;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function view(User $user, Contract $contract): bool
    {
        if ($this->owns($user, $contract)) {
            return true;
        }

        return $user->hasRole('super-admin');
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function update(User $user, Contract $contract): bool
    {
        return ($this->owns($user, $contract) || $user->hasRole('super-admin'))
            && $contract->armp_signature === null;
    }

    public function delete(User $user, Contract $contract): bool
    {
        return ($this->owns($user, $contract) || $user->hasRole('super-admin'))
            && $contract->dealer_signature === null;
    }

    public function sendForReview(User $user, Contract $contract): bool
    {
        return ($this->owns($user, $contract) || $user->hasRole('super-admin'))
            && $contract->dealer_signature === null;
    }

    public function generatePdf(User $user, Contract $contract): bool
    {
        return ($this->owns($user, $contract) || $user->hasRole('super-admin'))
            && $contract->armp_signature !== null;
    }

    public function sendPdf(User $user, Contract $contract): bool
    {
        return ($this->owns($user, $contract) || $user->hasRole('super-admin'))
            && $contract->pdf_path !== null;
    }

    public function downloadPdf(User $user, Contract $contract): bool
    {
        return ($this->owns($user, $contract) || $user->hasRole('super-admin'))
            && $contract->pdf_path !== null;
    }

    private function owns(User $user, Contract $contract): bool
    {
        return $contract->user_id === $user->id;
    }
}
