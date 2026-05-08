<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Data;

use App\Models\Dealer\Store;

class ComplianceSectionData
{
    /**
     * @param  list<string>  $ip_addresses
     * @param  list<string>  $website_urls
     * @param  list<string>  $service_contracts
     * @param  list<string>  $tire_wheel
     * @param  list<string>  $other_fi
     */
    public function __construct(
        public readonly ?string $police_emergency_phone,
        public readonly ?string $police_non_emergency_phone,
        public readonly ?string $fire_emergency_phone,
        public readonly ?string $fire_non_emergency_phone,
        public readonly ?string $fire_alarm_type,
        public readonly ?string $burglar_alarm_type,
        public readonly ?string $firewall_company,
        public readonly array $ip_addresses,
        public readonly ?string $mfa,
        public readonly ?string $vulnerability,
        public readonly ?string $currently_monitoring,
        public readonly ?string $antivirus_software,
        public readonly ?string $antivirus_computers,
        public readonly ?string $antivirus_minutes,
        public readonly ?string $screensaver_minutes,
        public readonly ?string $dms_provider,
        public readonly ?string $backups,
        public readonly array $website_urls,
        public readonly ?string $designated_red_flag_coordinator,
        public readonly ?string $document_shredding,
        public readonly ?string $service_provider_agreements,
        public readonly ?string $offsite_storage,
        public readonly ?string $other_business,
        public readonly ?string $vendor_access,
        public readonly ?string $personal_devices,
        public readonly ?string $compliance_issues,
        public readonly ?string $fi_products_sold,
        public readonly array $service_contracts,
        public readonly array $tire_wheel,
        public readonly array $other_fi,
        public readonly ?string $fi_system,
        public readonly ?string $appearance_protection_sold,
        public readonly bool $reinsurance,
        public readonly ?string $admin_name,
        public readonly ?string $fi_username,
        public readonly ?string $fi_password,
        public readonly ?float $standard_dpp_rate,
    ) {}

    public static function fromStore(Store $store): self
    {
        return new self(
            police_emergency_phone: $store->police_emergency_phone,
            police_non_emergency_phone: $store->police_non_emergency_phone,
            fire_emergency_phone: $store->fire_emergency_phone,
            fire_non_emergency_phone: $store->fire_non_emergency_phone,
            fire_alarm_type: $store->fire_alarm_type,
            burglar_alarm_type: $store->burglar_alarm_type,
            firewall_company: $store->firewall_company,
            ip_addresses: self::stringList($store->ip_addresses),
            mfa: $store->mfa,
            vulnerability: $store->vulnerability,
            currently_monitoring: $store->currently_monitoring === null ? null : (string) $store->currently_monitoring,
            antivirus_software: $store->antivirus_software,
            antivirus_computers: $store->antivirus_computers,
            antivirus_minutes: $store->antivirus_minutes,
            screensaver_minutes: $store->screensaver_minutes,
            dms_provider: $store->dms_provider,
            backups: $store->backups,
            website_urls: self::stringList($store->website_urls),
            designated_red_flag_coordinator: $store->designated_red_flag_coordinator,
            document_shredding: $store->document_shredding,
            service_provider_agreements: $store->service_provider_agreements,
            offsite_storage: $store->offsite_storage,
            other_business: $store->other_business,
            vendor_access: $store->vendor_access,
            personal_devices: $store->personal_devices,
            compliance_issues: $store->compliance_issues,
            fi_products_sold: $store->fi_products_sold,
            service_contracts: self::stringList($store->service_contracts),
            tire_wheel: self::stringList($store->tire_wheel),
            other_fi: self::stringList($store->other_fi),
            fi_system: $store->fi_system,
            appearance_protection_sold: $store->appearance_protection_sold,
            reinsurance: (bool) $store->reinsurance,
            admin_name: $store->admin_name,
            fi_username: $store->fi_username,
            fi_password: $store->fi_password,
            standard_dpp_rate: $store->standard_dpp_rate === null ? null : (float) $store->standard_dpp_rate,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'police_emergency_phone' => $this->police_emergency_phone,
            'police_non_emergency_phone' => $this->police_non_emergency_phone,
            'fire_emergency_phone' => $this->fire_emergency_phone,
            'fire_non_emergency_phone' => $this->fire_non_emergency_phone,
            'fire_alarm_type' => $this->fire_alarm_type,
            'burglar_alarm_type' => $this->burglar_alarm_type,
            'firewall_company' => $this->firewall_company,
            'ip_addresses' => $this->ip_addresses,
            'mfa' => $this->mfa,
            'vulnerability' => $this->vulnerability,
            'currently_monitoring' => $this->currently_monitoring,
            'antivirus_software' => $this->antivirus_software,
            'antivirus_computers' => $this->antivirus_computers,
            'antivirus_minutes' => $this->antivirus_minutes,
            'screensaver_minutes' => $this->screensaver_minutes,
            'dms_provider' => $this->dms_provider,
            'backups' => $this->backups,
            'website_urls' => $this->website_urls,
            'designated_red_flag_coordinator' => $this->designated_red_flag_coordinator,
            'document_shredding' => $this->document_shredding,
            'service_provider_agreements' => $this->service_provider_agreements,
            'offsite_storage' => $this->offsite_storage,
            'other_business' => $this->other_business,
            'vendor_access' => $this->vendor_access,
            'personal_devices' => $this->personal_devices,
            'compliance_issues' => $this->compliance_issues,
            'fi_products_sold' => $this->fi_products_sold,
            'service_contracts' => $this->service_contracts,
            'tire_wheel' => $this->tire_wheel,
            'other_fi' => $this->other_fi,
            'fi_system' => $this->fi_system,
            'appearance_protection_sold' => $this->appearance_protection_sold,
            'reinsurance' => $this->reinsurance,
            'admin_name' => $this->admin_name,
            'fi_username' => $this->fi_username,
            'fi_password' => $this->fi_password,
            'standard_dpp_rate' => $this->standard_dpp_rate,
        ];
    }

    /**
     * @return list<string>
     */
    private static function stringList(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        return array_values(array_map(static fn ($item): string => (string) $item, $value));
    }
}
