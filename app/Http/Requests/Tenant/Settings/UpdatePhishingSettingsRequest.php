<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Settings;

use App\Domain\Tenant\GlobalSettings\Data\UpdatePhishingSettingsData;
use App\Models\Dealer\GlobalSetting;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePhishingSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage', GlobalSetting::class) ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'phishing_active' => ['required', 'boolean'],
            'phishing_token' => ['nullable', 'string', 'max:255'],
            'phishing_ip' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function toData(): UpdatePhishingSettingsData
    {
        return new UpdatePhishingSettingsData(
            active: $this->boolean('phishing_active'),
            token: $this->validated('phishing_token'),
            ip: $this->validated('phishing_ip'),
        );
    }
}
