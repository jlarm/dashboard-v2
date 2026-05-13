<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Dashboard;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;

class UpdateConsultantNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole([Role::SuperAdmin->value, Role::Consultant->value]) === true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'note' => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function note(): ?string
    {
        /** @var array{note?: ?string} $validated */
        $validated = $this->validated();

        return $validated['note'] ?? null;
    }
}
