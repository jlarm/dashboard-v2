<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Livewire\Component;

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

    public function addIpAddress()
    {
        $this->ipAddresses->push(['phone_number' => '']);
    }

    public function addWebsiteUrl()
    {
        $this->websiteUrls->push(['url' => '']);
    }

    public function removeIpAddress($key)
    {
        $this->ipAddresses->pull($key);
    }

    public function removeWebsiteUrl($urlKey)
    {
        $this->websiteUrls->pull($urlKey);
    }

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
    ];

    public function mount()
    {
        $this->store = Store::where('id', $this->store->id)->first();
        $this->pep = $this->store->police_emergency_phone;
        $this->pnep = $this->store->police_non_emergency_phone;
        $this->fep = $this->store->fire_emergency_phone;
        $this->fnep = $this->store->fire_non_emergency_phone;
        $this->fireAlarm = $this->store->fire_alarm_type;
        $this->burglarAlarm = $this->store->burglar_alarm_type;
        $this->firewallCompany = $this->store->firewall_company;
        $this->ipAddresses = collect($this->store->ip_addresses)->map(function ($ip) {
            return ['ipAddress' => $ip];
        });
        $this->mfa = $this->store->mfa;
        $this->vulnerability = $this->store->vulnerability;
        $this->monitoring = $this->store->currently_monitoring;
        $this->antivirus = $this->store->antivirus_software;
        $this->antivirusComputers = $this->store->antivirus_computers;
        $this->antivirusMinutes = $this->store->antivirus_minutes;
        $this->screensaverMinutes = $this->store->screensaver_minutes;
        $this->dmsProvider = $this->store->dms_provider;
        $this->backups = $this->store->backups;
        $this->websiteUrls = collect($this->store->website_urls)->map(function ($url) {
            return ['websiteUrl' => $url];
        });
        $this->designatedRedFlagCoordinator = $this->store->designated_red_flag_coordinator;
        $this->documentShredding = $this->store->document_shredding;
        $this->serviceProviderAgreements = $this->store->service_provider_agreements;
        $this->offsiteStorage = $this->store->offsite_storage;
        $this->otherBusiness = $this->store->other_business;
        $this->vendorAccess = $this->store->vendor_access;
        $this->personalDevices = $this->store->personal_devices;
        $this->complianceIssues = $this->store->compliance_issues;
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
        ]);

        Notification::make()
            ->title('Settings Updated Successfully!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.store.single-onboarding-details');
    }
}
