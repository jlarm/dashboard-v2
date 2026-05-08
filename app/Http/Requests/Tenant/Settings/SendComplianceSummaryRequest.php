<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Settings;

use App\Enums\ComplianceSummaryFrequency;
use App\Models\Dealer\GlobalSetting;
use Illuminate\Foundation\Http\FormRequest;

class SendComplianceSummaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manageReports', GlobalSetting::class) ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'compliance_summary_frequency' => ['required', 'string'],
            'compliance_summary_recipients' => ['array'],
            'compliance_summary_recipients.*' => ['integer', 'exists:users,id'],
        ];
    }

    public function frequency(): ComplianceSummaryFrequency
    {
        return ComplianceSummaryFrequency::tryFrom((string) $this->validated('compliance_summary_frequency'))
            ?? ComplianceSummaryFrequency::Monthly;
    }

    /**
     * @return list<int>
     */
    public function recipientIds(): array
    {
        $values = $this->validated('compliance_summary_recipients') ?? [];

        return array_values(array_map(static fn ($value): int => (int) $value, $values));
    }
}
