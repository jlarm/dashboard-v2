<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store;

use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;

class SingleOnboardingDetails extends Component
{
    public $store;
    public $dealer;
    public $pep;
    public $pnep;
    public $fep;
    public $fnep;
    public $fireAlarm;
    public $burglarAlarm;
    public $firewallCompany;
    public Collection $ipAddresses;
    public $mfa;
    public $vulnerability;
    public $monitoring;
    public $antivirus;
    public $antivirusComputers;
    public $antivirusMinutes;
    public $screensaverMinutes;
    public $dmsProvider;
    public $backups;
    public Collection $websiteUrls;
    public $designatedRedFlagCoordinator;
    public $documentShredding;
    public $serviceProviderAgreements;
    public $offsiteStorage;
    public $otherBusiness;
    public $vendorAccess;
    public $personalDevices;
    public $complianceIssues;
    public $fi_products_sold;
    public Collection $service_contracts;
    public Collection $tire_wheel;
    public Collection $other_fi;
    public $fi_system;
    public $appearance_protection_sold;
    public $reinsurance;
    public $admin_name;
    public $fi_username;
    public $fi_password;
    public $standard_dpp_rate;
    protected $rules = [
        'pep' => 'nullable',
        'pnep' => 'nullable',
        'fep' => 'nullable',
        'fnep' => 'nullable',
        'fireAlarm' => 'nullable',
        'burglarAlarm' => 'nullable',
        'firewallCompany' => 'nullable',
        'ipAddresses.*.ipAddress' => 'nullable',
        'mfa' => 'nullable',
        'vulnerability' => 'nullable',
        'monitoring' => 'nullable',
        'antivirus' => 'nullable',
        'antivirusComputers' => 'nullable',
        'antivirusMinutes' => 'nullable',
        'screensaverMinutes' => 'nullable',
        'dmsProvider' => 'nullable',
        'backups' => 'nullable',
        'websiteUrls.*.url' => 'nullable',
        'designatedRedFlagCoordinator' => 'nullable',
        'documentShredding' => 'nullable',
        'serviceProviderAgreements' => 'nullable',
        'offsiteStorage' => 'nullable',
        'otherBusiness' => 'nullable',
        'vendorAccess' => 'nullable',
        'personalDevices' => 'nullable',
        'complianceIssues' => 'nullable',
        'fi_products_sold' => 'nullable',
        'service_contracts.*.contract' => 'nullable',
        'tire_wheel.*.tw' => 'nullable',
        'other_fi.*.fi' => 'nullable',
        'fi_system' => 'nullable',
        'appearance_protection_sold' => 'nullable',
        'reinsurance' => 'nullable',
        'admin_name' => 'nullable',
        'fi_username' => 'nullable',
        'fi_password' => 'nullable',
        'standard_dpp_rate' => 'nullable|numeric|min:0|max:100',
    ];

    public function addIpAddress(): void
    {
        $this->ipAddresses->push(['phone_number' => '']);
    }

    public function addWebsiteUrl(): void
    {
        $this->websiteUrls->push(['url' => '']);
    }

    public function removeIpAddress($key): void
    {
        $this->ipAddresses->pull($key);
    }

    public function removeWebsiteUrl($urlKey): void
    {
        $this->websiteUrls->pull($urlKey);
    }

    public function addServiceContract(): void
    {
        $this->service_contracts->push(['contract' => '']);
    }

    public function removeServiceContract($contractKey): void
    {
        $this->service_contracts->pull($contractKey);
    }

    public function addTireWheel(): void
    {
        $this->tire_wheel->push(['tireWheel' => '']);
    }

    public function removeTireWheel($tireKey): void
    {
        $this->tire_wheel->pull($tireKey);
    }

    public function addOtherFi(): void
    {
        $this->other_fi->push(['otherFi' => '']);
    }

    public function removeOtherFi($fiKey): void
    {
        $this->other_fi->pull($fiKey);
    }

    public function mount(): void
    {
        $this->store = Store::query()->where('id', $this->store->id)->first();
        $this->pep = $this->store->police_emergency_phone;
        $this->pnep = $this->store->police_non_emergency_phone;
        $this->fep = $this->store->fire_emergency_phone;
        $this->fnep = $this->store->fire_non_emergency_phone;
        $this->fireAlarm = $this->store->fire_alarm_type;
        $this->burglarAlarm = $this->store->burglar_alarm_type;
        $this->firewallCompany = $this->store->firewall_company;
        $this->ipAddresses = collect($this->store->ip_addresses)->map(fn ($ip): array => ['ipAddress' => $ip]);
        $this->mfa = $this->store->mfa;
        $this->vulnerability = $this->store->vulnerability;
        $this->monitoring = $this->store->currently_monitoring;
        $this->antivirus = $this->store->antivirus_software;
        $this->antivirusComputers = $this->store->antivirus_computers;
        $this->antivirusMinutes = $this->store->antivirus_minutes;
        $this->screensaverMinutes = $this->store->screensaver_minutes;
        $this->dmsProvider = $this->store->dms_provider;
        $this->backups = $this->store->backups;
        $this->websiteUrls = collect($this->store->website_urls)->map(fn ($url): array => ['websiteUrl' => $url]);
        $this->designatedRedFlagCoordinator = $this->store->designated_red_flag_coordinator;
        $this->documentShredding = $this->store->document_shredding;
        $this->serviceProviderAgreements = $this->store->service_provider_agreements;
        $this->offsiteStorage = $this->store->offsite_storage;
        $this->otherBusiness = $this->store->other_business;
        $this->vendorAccess = $this->store->vendor_access;
        $this->personalDevices = $this->store->personal_devices;
        $this->complianceIssues = $this->store->compliance_issues;
        $this->fi_products_sold = $this->store->fi_products_sold;
        $this->service_contracts = collect($this->store->service_contracts)->map(fn ($contract): array => ['serviceContract' => $contract]);
        $this->tire_wheel = collect($this->store->tire_wheel)->map(fn ($tw): array => ['tireWheel' => $tw]);
        $this->other_fi = collect($this->store->other_fi)->map(fn ($fi): array => ['otherFi' => $fi]);
        $this->fi_system = $this->store->fi_system;
        $this->appearance_protection_sold = $this->store->appearance_protection_sold;
        $this->reinsurance = $this->store->reinsurance;
        $this->admin_name = $this->store->admin_name;
        $this->fi_username = $this->store->fi_username;
        $this->fi_password = $this->store->fi_password ? Crypt::decryptString($this->store->fi_password) : null;
        $this->standard_dpp_rate = $this->store->standard_dpp_rate;
    }

    public function update(): void
    {
        $this->validate();

        $this->store->update([
            'police_emergency_phone' => $this->pep,
            'police_non_emergency_phone' => $this->pnep,
            'fire_emergency_phone' => $this->fep,
            'fire_non_emergency_phone' => $this->fnep,
            'fire_alarm_type' => $this->fireAlarm,
            'burglar_alarm_type' => $this->burglarAlarm,
            'firewall_company' => $this->firewallCompany,
            'ip_addresses' => $this->ipAddresses->pluck('ipAddress')->toArray(),
            'mfa' => $this->mfa,
            'vulnerability' => $this->vulnerability,
            'currently_monitoring' => $this->monitoring,
            'antivirus_software' => $this->antivirus,
            'antivirus_computers' => $this->antivirusComputers,
            'antivirus_minutes' => $this->antivirusMinutes,
            'screensaver_minutes' => $this->screensaverMinutes,
            'dms_provider' => $this->dmsProvider,
            'backups' => $this->backups,
            'website_urls' => $this->websiteUrls->pluck('websiteUrl')->toArray(),
            'designated_red_flag_coordinator' => $this->designatedRedFlagCoordinator,
            'document_shredding' => $this->documentShredding,
            'service_provider_agreements' => $this->serviceProviderAgreements,
            'offsite_storage' => $this->offsiteStorage,
            'other_business' => $this->otherBusiness,
            'vendor_access' => $this->vendorAccess,
            'personal_devices' => $this->personalDevices,
            'compliance_issues' => $this->complianceIssues,
            'fi_products_sold' => $this->fi_products_sold,
            'service_contracts' => $this->service_contracts->pluck('serviceContract')->toArray(),
            'tire_wheel' => $this->tire_wheel->pluck('tireWheel')->toArray(),
            'other_fi' => $this->other_fi->pluck('otherFi')->toArray(),
            'fi_system' => $this->fi_system,
            'appearance_protection_sold' => $this->appearance_protection_sold,
            'reinsurance' => $this->reinsurance,
            'admin_name' => $this->admin_name,
            'fi_username' => $this->fi_username,
            'fi_password' => Crypt::encryptString($this->fi_password),
            'standard_dpp_rate' => $this->standard_dpp_rate,
        ]);

        Notification::make()
            ->title('Settings Updated Successfully!')
            ->success()
            ->send();
    }

    public function download(): StreamedResponse
    {
        $html = view('dealer.settings.ComplianceInfoDownloadView', [
            'store' => $this->store,
        ])->render();

        $pdf = Browsershot::html($html)
            ->format('A4')
            ->margins(20, 10, 20, 10)
            ->pdf();

        return response()->streamDownload(function () use ($pdf): void {
            echo $pdf;
        }, str_replace(' ', '-', mb_strtolower($this->store->name)).'-compliance-info-'.now()->format('m-d-y').'.pdf');
    }

    public function render()
    {
        return view('livewire.dealer.store.single-onboarding-details');
    }
}
