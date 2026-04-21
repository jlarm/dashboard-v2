<?php

declare(strict_types=1);

namespace App\Http\Requests\Central\Contract;

use Illuminate\Foundation\Http\FormRequest;

class ReviewContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'dealer_physical_address' => ['required', 'string', 'max:255'],
            'dealer_physical_city' => ['required', 'string', 'max:255'],
            'dealer_physical_state' => ['required', 'string', 'max:255'],
            'dealer_physical_zip' => ['required', 'string', 'max:20'],
            'dealer_phone' => ['required', 'string', 'max:50'],
            'dealer_qi_name' => ['required', 'string', 'max:255'],
            'dealer_qi_email' => ['required', 'email', 'max:255'],
            'dealer_billing_address' => ['required', 'string', 'max:255'],
            'dealer_billing_city' => ['required', 'string', 'max:255'],
            'dealer_billing_state' => ['required', 'string', 'max:255'],
            'dealer_billing_zip' => ['required', 'string', 'max:20'],
            'dealer_billing_fax' => ['nullable', 'string', 'max:50'],
            'dealer_billing_contact_name' => ['required', 'string', 'max:255'],
            'dealer_billing_contact_title' => ['required', 'string', 'max:255'],
            'dealer_billing_contact_email' => ['required', 'email', 'max:255'],
            'dealer_printed_name' => ['required', 'string', 'max:255'],
            'dealer_signature' => ['required', 'string'],
            'additional_locations' => ['nullable', 'array'],
            'additional_locations.*.name' => ['required', 'string', 'max:255'],
            'additional_locations.*.address' => ['required', 'string', 'max:255'],
            'additional_locations.*.city' => ['required', 'string', 'max:255'],
            'additional_locations.*.state' => ['required', 'string', 'max:255'],
            'additional_locations.*.zip' => ['required', 'string', 'max:20'],
            'additional_locations.*.contact_name' => ['nullable', 'string', 'max:255'],
            'additional_locations.*.contact_title' => ['nullable', 'string', 'max:255'],
            'additional_locations.*.contact_email' => ['nullable', 'email', 'max:255'],
        ];
    }
}
