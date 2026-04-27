<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Enums\Role;
use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;
use App\Models\User;
use Illuminate\Support\Str;

class InviteEmployee
{
    /**
     * @param  list<int>  $storeIds
     * @param  array<string, string>  $courses
     */
    public function handle(
        User $inviter,
        string $name,
        string $email,
        int $departmentId,
        string $role,
        bool $qualifiedIndividual,
        array $storeIds,
        ?int $primaryStoreId,
        array $courses,
    ): Invite {
        $roles = [$role];
        if ($qualifiedIndividual) {
            $roles[] = Role::QualifiedIndividual->value;
        }

        $invite = Invite::query()->create([
            'name' => $name,
            'email' => $email,
            'stores' => $storeIds === [] ? null : array_map(strval(...), $storeIds),
            'primary_store_id' => count($storeIds) > 1 ? $primaryStoreId : null,
            'department_id' => $departmentId,
            'user_id' => $inviter->id,
            'roles' => array_values(array_unique($roles)),
            'courses' => $courses,
            'invitation_token' => Str::random(32),
        ]);

        dispatch(new SendQueueEmailJob($invite));

        return $invite;
    }
}
