<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\StoreSettings;

use App\Domain\Tenant\StoreSettings\Data\ManagersSectionData;
use App\Models\Dealer\Store;
use Illuminate\Foundation\Http\FormRequest;

class UpdateManagersRequest extends FormRequest
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
            'qualified_individual_name' => ['nullable', 'string', 'max:255'],
            'qualified_individual_phone' => ['nullable', 'string', 'max:255'],
            'service_manager_name' => ['nullable', 'string', 'max:255'],
            'service_manager_phone' => ['nullable', 'string', 'max:255'],
            'parts_manager_name' => ['nullable', 'string', 'max:255'],
            'parts_manager_phone' => ['nullable', 'string', 'max:255'],
            'body_shop_manager_name' => ['nullable', 'string', 'max:255'],
            'body_shop_manager_phone' => ['nullable', 'string', 'max:255'],
            'general_manager_name' => ['nullable', 'string', 'max:255'],
            'general_manager_phone' => ['nullable', 'string', 'max:255'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'owner_phone' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function toData(): ManagersSectionData
    {
        return new ManagersSectionData(
            qualified_individual_name: $this->stringOrNull('qualified_individual_name'),
            qualified_individual_phone: $this->stringOrNull('qualified_individual_phone'),
            service_manager_name: $this->stringOrNull('service_manager_name'),
            service_manager_phone: $this->stringOrNull('service_manager_phone'),
            parts_manager_name: $this->stringOrNull('parts_manager_name'),
            parts_manager_phone: $this->stringOrNull('parts_manager_phone'),
            body_shop_manager_name: $this->stringOrNull('body_shop_manager_name'),
            body_shop_manager_phone: $this->stringOrNull('body_shop_manager_phone'),
            general_manager_name: $this->stringOrNull('general_manager_name'),
            general_manager_phone: $this->stringOrNull('general_manager_phone'),
            owner_name: $this->stringOrNull('owner_name'),
            owner_phone: $this->stringOrNull('owner_phone'),
        );
    }

    private function stringOrNull(string $key): ?string
    {
        $value = $this->validated($key);

        return $value === null || $value === '' ? null : (string) $value;
    }
}
