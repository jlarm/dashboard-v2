<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\User;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;

class ResendInvitesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(Role::values(Role::employeeSectionViewers())) ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'invite_ids' => ['required', 'array', 'min:1'],
            'invite_ids.*' => ['integer', 'exists:invites,id'],
        ];
    }

    /**
     * @return list<int>
     */
    public function inviteIds(): array
    {
        /** @var list<int|string> $ids */
        $ids = $this->validated('invite_ids', []);

        return array_values(array_unique(array_map(static fn (int|string $id): int => (int) $id, $ids)));
    }
}
