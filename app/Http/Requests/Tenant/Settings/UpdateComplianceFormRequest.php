<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Settings;

use App\Domain\Tenant\StoreSettings\Data\ComplianceSectionData;
use App\Domain\Tenant\StoreSettings\Data\ManagersSectionData;
use App\Models\Dealer\Store;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates the public, signed-URL compliance form. Access is gated by the
 * `signed` middleware on the route, so the request itself authorizes freely.
 */
class UpdateComplianceFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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
            'reinsurance' => ['nullable', 'boolean'],
            'admin_name' => ['nullable', 'string', 'max:255'],
            'fi_username' => ['nullable', 'string', 'max:255'],
            'fi_password' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function toManagersData(): ManagersSectionData
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

    public function toComplianceData(Store $store): ComplianceSectionData
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
            antivirus_minutes: $store->antivirus_minutes === null ? null : (string) $store->antivirus_minutes,
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
            standard_dpp_rate: $store->standard_dpp_rate === null ? null : (float) $store->standard_dpp_rate,
        );
    }

    private function stringOrNull(string $key): ?string
    {
        $value = $this->validated($key);

        return $value === null || $value === '' ? null : (string) $value;
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
