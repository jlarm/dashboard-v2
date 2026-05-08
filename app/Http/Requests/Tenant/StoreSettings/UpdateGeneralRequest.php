<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\StoreSettings;

use App\Domain\Tenant\StoreSettings\Data\UpdateGeneralData;
use App\Enums\Frequency;
use App\Models\Dealer\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class UpdateGeneralRequest extends FormRequest
{
    public function authorize(): bool
    {
        $store = $this->route('store');

        return $store instanceof Store && ($this->user()?->can('update', $store) ?? false);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:50'],
            'website' => ['nullable', 'string', 'max:255'],
            'active_monitoring' => ['required', 'boolean'],
            'monitoring_start_date' => ['nullable', 'date'],
            'courses_not_taken_notification' => ['required', 'boolean'],
            'videos' => ['required', 'boolean'],
            'remediations_active' => ['required', 'boolean'],
            'remediation_notifications' => ['required', 'boolean'],
            'remediation_frequency' => [
                'nullable',
                Rule::enum(Frequency::class),
                'required_if:remediation_notifications,true',
            ],
            'phishing_active' => ['required', 'boolean'],
            'phishing_token' => ['nullable', 'string', 'max:255'],
            'phishing_ip' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    #[Override]
    public function messages(): array
    {
        return [
            'remediation_frequency.required_if' => 'Frequency is required when remediation notifications are enabled.',
        ];
    }

    public function toData(): UpdateGeneralData
    {
        $frequency = $this->validated('remediation_frequency');

        return new UpdateGeneralData(
            name: (string) $this->validated('name'),
            address: $this->stringOrNull('address'),
            city: $this->stringOrNull('city'),
            state: $this->stringOrNull('state'),
            postal_code: $this->stringOrNull('postal_code'),
            phone: $this->stringOrNull('phone'),
            website: $this->stringOrNull('website'),
            active_monitoring: $this->boolean('active_monitoring'),
            monitoring_start_date: $this->stringOrNull('monitoring_start_date'),
            courses_not_taken_notification: $this->boolean('courses_not_taken_notification'),
            videos: $this->boolean('videos'),
            remediations_active: $this->boolean('remediations_active'),
            remediation_notifications: $this->boolean('remediation_notifications'),
            remediation_frequency: $frequency === null ? null : Frequency::from((string) $frequency),
            phishing_active: $this->boolean('phishing_active'),
            phishing_token: $this->stringOrNull('phishing_token'),
            phishing_ip: $this->stringOrNull('phishing_ip'),
        );
    }

    private function stringOrNull(string $key): ?string
    {
        $value = $this->validated($key);

        return $value === null || $value === '' ? null : (string) $value;
    }
}
