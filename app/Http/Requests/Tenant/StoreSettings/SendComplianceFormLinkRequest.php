<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\StoreSettings;

use App\Models\Dealer\Store;
use Illuminate\Foundation\Http\FormRequest;

class SendComplianceFormLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        $store = $this->route('store');

        return $store instanceof Store && ($this->user()?->can('update', $store) ?? false);
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc', 'max:255'],
        ];
    }

    public function recipientEmail(): string
    {
        return (string) $this->validated('email');
    }
}
