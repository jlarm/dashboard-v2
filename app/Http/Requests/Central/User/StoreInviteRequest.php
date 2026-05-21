<?php

declare(strict_types=1);

namespace App\Http\Requests\Central\User;

use App\Models\Central\UserInvite;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class StoreInviteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', UserInvite::class) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
                Rule::unique(UserInvite::class, 'email')
                    ->where(fn (Builder $query) => $query
                        ->whereNull('accepted_at')
                        ->whereNull('revoked_at')
                        ->where('expires_at', '>', now())),
            ],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'email.unique' => 'This email already has an active invite.',
        ];
    }
}
