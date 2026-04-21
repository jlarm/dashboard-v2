<?php

declare(strict_types=1);

namespace App\Http\Requests\Central\Contract;

use App\Enums\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('contract')) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'contract_type' => ['required', 'string', Rule::in(['yearly', 'monthly'])],
            'agreement_date' => ['required', 'date'],
            'dealer_name' => ['required', 'string', 'max:255'],
            'services' => ['required', 'array', 'min:1'],
            'services.*' => ['required', 'string', Rule::in(array_column(Service::cases(), 'value'))],
            'commence_date' => ['required', 'date'],
            'yearly_inspection_total' => ['required', 'integer', 'min:0'],
            'initial_fee' => ['required', 'numeric', 'min:0'],
            'monthly_fee' => ['required', 'numeric', 'min:0'],
            'armp_printed_name' => ['nullable', 'string', 'max:255'],
            'armp_signature' => ['nullable', 'string'],
            'dealer_physical_address' => ['nullable', 'string', 'max:255'],
            'dealer_physical_city' => ['nullable', 'string', 'max:255'],
            'dealer_physical_state' => ['nullable', 'string', 'max:255'],
            'dealer_physical_zip' => ['nullable', 'string', 'max:20'],
            'dealer_phone' => ['nullable', 'string', 'max:50'],
            'dealer_qi_name' => ['nullable', 'string', 'max:255'],
            'dealer_qi_email' => ['nullable', 'email', 'max:255'],
            'dealer_billing_address' => ['nullable', 'string', 'max:255'],
            'dealer_billing_city' => ['nullable', 'string', 'max:255'],
            'dealer_billing_state' => ['nullable', 'string', 'max:255'],
            'dealer_billing_zip' => ['nullable', 'string', 'max:20'],
            'dealer_billing_fax' => ['nullable', 'string', 'max:50'],
            'dealer_billing_contact_name' => ['nullable', 'string', 'max:255'],
            'dealer_billing_contact_title' => ['nullable', 'string', 'max:255'],
            'dealer_billing_contact_email' => ['nullable', 'email', 'max:255'],
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
