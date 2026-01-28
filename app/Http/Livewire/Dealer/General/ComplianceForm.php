<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\General;

use App\Models\Dealer\Store;
use Filament\Forms;
use Filament\Notifications\Notification;
use Livewire\Component;

class ComplianceForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public Store $store;
    public $firewall_company;
    public $ip_addresses = [''];
    public $ip_address;
    public $mfa = '';
    public $vulnerability;
    public $currently_monitoring;
    public $antivirus_software;
    public $antivirus_computers;
    public $antivirus_minutes;
    public $screensaver_minutes;
    public $dms_provider;
    public $website_urls = [''];
    public $backups;
    public $designated_red_flag_coordinator;
    public $document_shredding;
    public $service_provider_agreements;
    public $offsite_storage;
    public $other_business;
    public $vendor_access;
    public $personal_devices;
    public $compliance_issues;
    public $fi_products_sold;
    public $service_contracts = [''];
    public $tire_wheel = [''];
    public $other_fi = [''];
    public $fi_system;
    public $appearance_protection_sold;
    public $reinsurance;
    public $admin_name;
    public $i = 1;
    public $u = 0;
    protected $rules = [
        'firewall_company' => 'nullable',
        'ip_addresses' => 'nullable|array',
        'mfa' => 'nullable|boolean',
        'vulnerability' => 'nullable|boolean',
        'currently_monitoring' => 'nullable|boolean',
        'antivirus_software' => 'nullable',
        'antivirus_computers' => 'nullable',
        'antivirus_minutes' => 'nullable',
        'screensaver_minutes' => 'nullable',
        'dms_provider' => 'nullable',
        'website_urls' => 'nullable|array',
        'backups' => 'nullable',
        'designated_red_flag_coordinator' => 'nullable',
        'document_shredding' => 'nullable|boolean',
        'service_provider_agreements' => 'nullable|boolean',
        'offsite_storage' => 'nullable|boolean',
        'other_business' => 'nullable|boolean',
        'vendor_access' => 'nullable|boolean',
        'personal_devices' => 'nullable|boolean',
        'compliance_issues' => 'nullable|boolean',
        'fi_products_sold' => 'nullable',
        'service_contracts' => 'nullable|array',
        'tire_wheel' => 'nullable|array',
        'other_fi' => 'nullable|array',
        'fi_system' => 'nullable',
        'appearance_protection_sold' => 'nullable',
        'reinsurance' => 'nullable|boolean',
        'admin_name' => 'nullable',
    ];

    public function mount()
    {
        $this->store_id = $this->store->id;
        $this->firewall_company = $this->store->firewall_company;
        $this->ip_addresses = $this->store->ip_addresses;
        $this->mfa = $this->store->mfa;
        $this->vulnerability = $this->store->vulnerability;
        $this->currently_monitoring = $this->store->currently_monitoring;
        $this->antivirus_software = $this->store->antivirus_software;
        $this->antivirus_computers = $this->store->antivirus_computers;
        $this->antivirus_minutes = $this->store->antivirus_minutes;
        $this->screensaver_minutes = $this->store->screensaver_minutes;
        $this->dms_provider = $this->store->dms_provider;
        $this->website_urls = $this->store->website_urls;
        $this->backups = $this->store->backups;
        $this->designated_red_flag_coordinator = $this->store->designated_red_flag_coordinator;
        $this->document_shredding = $this->store->document_shredding;
        $this->service_provider_agreements = $this->store->service_provider_agreements;
        $this->offsite_storage = $this->store->offsite_storage;
        $this->other_business = $this->store->other_business;
        $this->vendor_access = $this->store->vendor_access;
        $this->personal_devices = $this->store->personal_devices;
        $this->compliance_issues = $this->store->compliance_issues;
        $this->fi_products_sold = $this->store->fi_products_sold;
        $this->service_contracts = $this->store->service_contracts;
        $this->tire_wheel = $this->store->tire_wheel;
        $this->other_fi = $this->store->other_fi;
        $this->fi_system = $this->store->fi_system;
        $this->appearance_protection_sold = $this->store->appearance_protection_sold;
        $this->reinsurance = $this->store->reinsurance;
        $this->admin_name = $this->store->admin_name;
    }

    public function addIp()
    {
        $this->ip_addresses[] = '';
    }

    public function addUrl($u)
    {
        $this->website_urls[] = '';
    }

    public function removeIp($index)
    {
        unset($this->ip_addresses[$index]);
        $this->ip_addresses = array_values($this->ip_addresses);
    }

    public function removeUrl($index)
    {
        unset($this->website_urls[$index]);
        $this->website_urls = array_values($this->website_urls);
    }

    public function save()
    {
        $this->validate();

        $this->store->update([
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
            'website_urls' => $this->website_urls,
            'backups' => $this->backups,
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
        ]);

        Notification::make()
            ->title('Updated Successfully!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.general.compliance-form');
    }
}
