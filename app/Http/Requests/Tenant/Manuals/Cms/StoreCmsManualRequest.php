<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Manuals\Cms;

use App\Domain\Tenant\Manuals\Cms\Data\CmsManualFormData;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreCmsManualRequest extends FormRequest
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
        $signatureRule = ['nullable', 'string', 'starts_with:data:image/png;base64,'];

        return [
            'qi_name' => ['required', 'string', 'max:255'],
            'standard_dpp_rate' => ['required', 'string'],
            'adoption_approval_name_one' => ['nullable', 'string', 'max:255'],
            'adoption_approval_signature_one' => $signatureRule,
            'adoption_approval_name_two' => ['nullable', 'string', 'max:255'],
            'adoption_approval_signature_two' => $signatureRule,
            'adoption_approval_name_three' => ['nullable', 'string', 'max:255'],
            'adoption_approval_signature_three' => $signatureRule,
            'dealer_participation_name' => ['nullable', 'string', 'max:255'],
            'dealer_participation_signature' => $signatureRule,
            'acknowledgement_name' => ['required', 'string', 'max:255'],
            'acknowledgement_signature' => ['required', 'string', 'starts_with:data:image/png;base64,'],
        ];
    }

    /**
     * @return array<string, string>
     */
    #[Override]
    public function messages(): array
    {
        return [
            'qi_name.required' => 'A Qualified Individual is required to complete the CMS manual.',
            'standard_dpp_rate.required' => 'A standard DPP rate is required to complete the CMS manual.',
            'acknowledgement_name.required' => 'An acknowledgement name is required.',
            'acknowledgement_signature.required' => 'An acknowledgement signature is required.',
            'acknowledgement_signature.starts_with' => 'The acknowledgement signature could not be read. Please clear and sign again.',
        ];
    }

    public function toData(): CmsManualFormData
    {
        /** @var array<string, mixed> $validated */
        $validated = $this->validated();

        return new CmsManualFormData(
            qiName: (string) $validated['qi_name'],
            standardDppRate: (string) $validated['standard_dpp_rate'],
            adoptionApprovalNameOne: $validated['adoption_approval_name_one'] ?? null,
            adoptionApprovalSignatureOne: $validated['adoption_approval_signature_one'] ?? null,
            adoptionApprovalNameTwo: $validated['adoption_approval_name_two'] ?? null,
            adoptionApprovalSignatureTwo: $validated['adoption_approval_signature_two'] ?? null,
            adoptionApprovalNameThree: $validated['adoption_approval_name_three'] ?? null,
            adoptionApprovalSignatureThree: $validated['adoption_approval_signature_three'] ?? null,
            dealerParticipationName: $validated['dealer_participation_name'] ?? null,
            dealerParticipationSignature: $validated['dealer_participation_signature'] ?? null,
            acknowledgementName: (string) $validated['acknowledgement_name'],
            acknowledgementSignature: (string) $validated['acknowledgement_signature'],
        );
    }
}
