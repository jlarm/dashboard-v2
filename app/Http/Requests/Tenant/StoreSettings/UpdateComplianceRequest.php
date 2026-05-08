<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\StoreSettings;

use App\Domain\Tenant\StoreSettings\Data\ComplianceSectionData;
use App\Models\Dealer\Store;
use Illuminate\Foundation\Http\FormRequest;

class UpdateComplianceRequest extends FormRequest
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
            'police_emergency_phone' => ['nullable', 'string', 'max:255'],
            'police_non_emergency_phone' => ['nullable', 'string', 'max:255'],
            'fire_emergency_phone' => ['nullable', 'string', 'max:255'],
            'fire_non_emergency_phone' => ['nullable', 'string', 'max:255'],
            'fire_alarm_type' => ['nullable', 'string', 'max:255'],
            'burglar_alarm_type' => ['nullable', 'string', 'max:255'],

            'firewall_company' => ['nullable', 'string', 'max:255'],
            'ip_addresses' => ['nullable', 'array'],
            'ip_addresses.*' => ['nullable', 'string', 'max:255'],
            'mfa' => ['nullable', 'string', 'max:255'],
            'vulnerability' => ['nullable', 'string', 'max:255'],
            'currently_monitoring' => ['nullable', 'string', 'max:255'],
            'antivirus_software' => ['nullable', 'string', 'max:255'],
            'antivirus_computers' => ['nullable', 'string', 'max:255'],
            'antivirus_minutes' => ['nullable', 'string', 'max:255'],
            'screensaver_minutes' => ['nullable', 'string', 'max:255'],
            'dms_provider' => ['nullable', 'string', 'max:255'],
            'backups' => ['nullable', 'string', 'max:255'],
            'website_urls' => ['nullable', 'array'],
            'website_urls.*' => ['nullable', 'string', 'max:1024'],

            'designated_red_flag_coordinator' => ['nullable', 'string', 'max:255'],
            'document_shredding' => ['nullable', 'string', 'max:255'],
            'service_provider_agreements' => ['nullable', 'string', 'max:255'],
            'offsite_storage' => ['nullable', 'string', 'max:255'],
            'other_business' => ['nullable', 'string', 'max:255'],
            'vendor_access' => ['nullable', 'string', 'max:255'],
            'personal_devices' => ['nullable', 'string', 'max:255'],
            'compliance_issues' => ['nullable', 'string', 'max:1024'],

            'fi_products_sold' => ['nullable', 'string', 'max:255'],
            'service_contracts' => ['nullable', 'array'],
            'service_contracts.*' => ['nullable', 'string', 'max:255'],
            'tire_wheel' => ['nullable', 'array'],
            'tire_wheel.*' => ['nullable', 'string', 'max:255'],
            'other_fi' => ['nullable', 'array'],
            'other_fi.*' => ['nullable', 'string', 'max:255'],
            'fi_system' => ['nullable', 'string', 'max:255'],
            'appearance_protection_sold' => ['nullable', 'string', 'max:255'],
            'reinsurance' => ['required', 'boolean'],
            'admin_name' => ['nullable', 'string', 'max:255'],
            'fi_username' => ['nullable', 'string', 'max:255'],
            'fi_password' => ['nullable', 'string', 'max:255'],
            'standard_dpp_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public function toData(): ComplianceSectionData
    {
        return new ComplianceSectionData(
            police_emergency_phone: $this->stringOrNull('police_emergency_phone'),
            police_non_emergency_phone: $this->stringOrNull('police_non_emergency_phone'),
            fire_emergency_phone: $this->stringOrNull('fire_emergency_phone'),
            fire_non_emergency_phone: $this->stringOrNull('fire_non_emergency_phone'),
            fire_alarm_type: $this->stringOrNull('fire_alarm_type'),
            burglar_alarm_type: $this->stringOrNull('burglar_alarm_type'),
            firewall_company: $this->stringOrNull('firewall_company'),
            ip_addresses: $this->stringList('ip_addresses'),
            mfa: $this->stringOrNull('mfa'),
            vulnerability: $this->stringOrNull('vulnerability'),
            currently_monitoring: $this->stringOrNull('currently_monitoring'),
            antivirus_software: $this->stringOrNull('antivirus_software'),
            antivirus_computers: $this->stringOrNull('antivirus_computers'),
            antivirus_minutes: $this->stringOrNull('antivirus_minutes'),
            screensaver_minutes: $this->stringOrNull('screensaver_minutes'),
            dms_provider: $this->stringOrNull('dms_provider'),
            backups: $this->stringOrNull('backups'),
            website_urls: $this->stringList('website_urls'),
            designated_red_flag_coordinator: $this->stringOrNull('designated_red_flag_coordinator'),
            document_shredding: $this->stringOrNull('document_shredding'),
            service_provider_agreements: $this->stringOrNull('service_provider_agreements'),
            offsite_storage: $this->stringOrNull('offsite_storage'),
            other_business: $this->stringOrNull('other_business'),
            vendor_access: $this->stringOrNull('vendor_access'),
            personal_devices: $this->stringOrNull('personal_devices'),
            compliance_issues: $this->stringOrNull('compliance_issues'),
            fi_products_sold: $this->stringOrNull('fi_products_sold'),
            service_contracts: $this->stringList('service_contracts'),
            tire_wheel: $this->stringList('tire_wheel'),
            other_fi: $this->stringList('other_fi'),
            fi_system: $this->stringOrNull('fi_system'),
            appearance_protection_sold: $this->stringOrNull('appearance_protection_sold'),
            reinsurance: $this->boolean('reinsurance'),
            admin_name: $this->stringOrNull('admin_name'),
            fi_username: $this->stringOrNull('fi_username'),
            fi_password: $this->stringOrNull('fi_password'),
            standard_dpp_rate: $this->floatOrNull('standard_dpp_rate'),
        );
    }

    private function stringOrNull(string $key): ?string
    {
        $value = $this->validated($key);

        return $value === null || $value === '' ? null : (string) $value;
    }

    private function floatOrNull(string $key): ?float
    {
        $value = $this->validated($key);

        return $value === null || $value === '' ? null : (float) $value;
    }

    /**
     * @return list<string>
     */
    private function stringList(string $key): array
    {
        $values = $this->validated($key) ?? [];

        if (! is_array($values)) {
            return [];
        }

        $clean = [];
        foreach ($values as $value) {
            $value = (string) $value;
            if ($value !== '') {
                $clean[] = $value;
            }
        }

        return $clean;
    }
}
