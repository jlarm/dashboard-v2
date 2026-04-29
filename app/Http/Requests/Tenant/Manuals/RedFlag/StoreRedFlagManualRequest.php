<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Manuals\RedFlag;

use App\Domain\Tenant\Manuals\RedFlag\Data\RedFlagManualFormData;
use Illuminate\Foundation\Http\FormRequest;

class StoreRedFlagManualRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'signature' => ['required', 'string', 'starts_with:data:image/png;base64,'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'signature.required' => 'A signature is required to sign the manual.',
            'signature.starts_with' => 'The signature could not be read. Please clear and sign again.',
        ];
    }

    public function toData(): RedFlagManualFormData
    {
        /** @var array{signature: string} $validated */
        $validated = $this->validated();

        return new RedFlagManualFormData(
            signatureDataUri: $validated['signature'],
        );
    }
}
