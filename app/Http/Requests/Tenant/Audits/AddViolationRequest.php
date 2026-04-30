<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Audits;

use Illuminate\Foundation\Http\FormRequest;

class AddViolationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'statement_id' => ['required', 'integer'],
        ];
    }

    public function statementId(): int
    {
        /** @var array{statement_id: int|string} $validated */
        $validated = $this->validated();

        return (int) $validated['statement_id'];
    }
}
