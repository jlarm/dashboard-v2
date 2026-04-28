<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Vendor;

use App\Domain\Tenant\Vendor\Data\SubmitVendorFormData;
use App\Domain\Tenant\Vendor\Support\RiskAssessmentQuestions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class SubmitVendorFormRequest extends FormRequest
{
    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        if ($this->hasFile('document')) {
            return [
                'document' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            ];
        }

        return [
            'signature' => ['required', 'string'],
            'responses' => ['required', 'array', 'size:'.RiskAssessmentQuestions::COUNT],
            'responses.*.response' => ['required', Rule::in(['yes', 'no', 'na'])],
            'responses.*.comment' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toData(): SubmitVendorFormData
    {
        $document = $this->file('document');

        return new SubmitVendorFormData(
            document: $document instanceof UploadedFile ? $document : null,
            signature: $this->validated('signature'),
            responses: $this->validated('responses'),
        );
    }
}
