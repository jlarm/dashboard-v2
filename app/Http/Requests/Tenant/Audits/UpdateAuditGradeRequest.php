<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Audits;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuditGradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'grade' => ['required', 'string', 'in:A,B,C,D,F'],
        ];
    }

    public function grade(): string
    {
        /** @var array{grade: string} $validated */
        $validated = $this->validated();

        return $validated['grade'];
    }
}
