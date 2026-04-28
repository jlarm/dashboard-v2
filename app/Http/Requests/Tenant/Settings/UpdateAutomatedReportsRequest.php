<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Settings;

use App\Enums\ComplianceSummaryFrequency;
use App\Models\Dealer\GlobalSetting;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAutomatedReportsRequest extends FormRequest
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
            'compliance_summary_active' => ['required', 'boolean'],
            'compliance_summary_frequency' => ['required', Rule::enum(ComplianceSummaryFrequency::class)],
            'compliance_summary_recipients' => [
                'array',
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($this->boolean('compliance_summary_active') && (! is_array($value) || $value === [])) {
                        $fail('At least one recipient is required when the compliance summary is enabled.');
                    }
                },
            ],
            'compliance_summary_recipients.*' => ['integer', 'exists:users,id'],
        ];
    }
}
