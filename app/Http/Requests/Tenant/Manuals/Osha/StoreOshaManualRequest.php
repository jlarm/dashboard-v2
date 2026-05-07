<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Manuals\Osha;

use App\Domain\Tenant\Manuals\Osha\Data\OshaManualFormData;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreOshaManualRequest extends FormRequest
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
    #[Override]
    public function messages(): array
    {
        return [
            'signature.required' => 'A signature is required to sign the manual.',
            'signature.starts_with' => 'The signature could not be read. Please clear and sign again.',
        ];
    }

    public function toData(): OshaManualFormData
    {
        /** @var array{signature: string} $validated */
        $validated = $this->validated();

        return new OshaManualFormData(
            signatureDataUri: $validated['signature'],
        );
    }
}
