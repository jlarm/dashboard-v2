<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Notifications\Notification;
use Livewire\Component;

class SingleOnboardingDetails extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $store;
    public $dealer;

    public function mount(Store $store)
    {
        if ($store->id === null) {
            $this->dealer = Store::first();
        } else {
            $this->dealer = Store::where('id', $this->store->id)->first();
        }

        $this->form->fill([
            'police_emergency_phone' => $this->dealer->police_emergency_phone,
            'police_non_emergency_phone' => $this->dealer->police_non_emergency_phone,
            'fire_emergency_phone' => $this->dealer->fire_emergency_phone,
            'fire_non_emergency_phone' => $this->dealer->fire_non_emergency_phone,
            'fire_alarm_type' => $this->dealer->fire_alarm_type,
            'burglar_alarm_type' => $this->dealer->burglar_alarm_type,
            'firewall_company' => $this->dealer->firewall_company,
            'ip_addresses' => $this->dealer->ip_addresses,
            'mfa' => $this->dealer->mfa,
            'vulnerability' => $this->dealer->vulnerability,
            'currently_monitoring' => $this->dealer->currently_monitoring,
            'antivirus_software' => $this->dealer->antivirus_software,
            'antivirus_computers' => $this->dealer->antivirus_computers,
            'antivirus_minutes' => $this->dealer->antivirus_minutes,
            'screensaver_minutes' => $this->dealer->screensaver_minutes,
            'dms_provider' => $this->dealer->dms_provider,
            'website_urls' => $this->dealer->website_urls,
            'backups' => $this->dealer->backups,
            'designated_red_flag_coordinator' => $this->dealer->designated_red_flag_coordinator,
            'document_shredding' => $this->dealer->document_shredding,
            'service_provider_agreements' => $this->dealer->service_provider_agreements,
            'offsite_storage' => $this->dealer->offsite_storage,
            'other_business' => $this->dealer->other_business,
            'vendor_access' => $this->dealer->vendor_access,
            'personal_devices' => $this->dealer->personal_devices,
            'compliance_issues' => $this->dealer->compliance_issues,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\TextInput::make('police_emergency_phone')
                    ->label('Police Emergency Phone Number'),
                    Forms\Components\TextInput::make('police_non_emergency_phone')
                    ->label('Police Non-Emergency Phone Number'),
                    Forms\Components\TextInput::make('fire_emergency_phone')
                    ->label('Fire Emergency Phone Number'),
                    Forms\Components\TextInput::make('fire_non_emergency_phone')
                    ->label('Fire Non-Emergency Phone Number'),
                    Forms\Components\TextInput::make('fire_alarm_type')
                    ->label('What type of fire alarm System do you use?'),
                    Forms\Components\TextInput::make('burglar_alarm_type')
                    ->label('What type of Burglar Alarm System do you use?'),
                ]),
            Forms\Components\TextInput::make('firewall_company'),
            Forms\Components\Repeater::make('ip_addresses')
                ->schema([
                    Forms\Components\TextInput::make('ip_address'),
                ])
            ->createItemButtonLabel('Add IP Address')
            ->label('IP Addresses'),
            Forms\Components\Radio::make('mfa')
                ->options([
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->label('Multi-Factor Authentication (MFA) - Do you have it installed and being utilized?'),
            Forms\Components\Radio::make('vulnerability')
                ->options([
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->label('Are IT Vulnerability scans currently being completed?'),
            Forms\Components\Radio::make('currently_monitoring')
                ->options([
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->label('Are you currently Monitoring & Logging User Activity at your dealership?'),
            Forms\Components\TextInput::make('antivirus_software')
                ->label('Antivirus Software'),
            Forms\Components\TextInput::make('antivirus_computers')
                ->label('Anti-Virus Applied on individual computers or through server?'),
            Forms\Components\TextInput::make('screensaver_minutes')
                ->numeric()
                ->label('How many minutes are the monitors set for screen saver activation?'),
            Forms\Components\TextInput::make('dms_provider')
                ->label('Who is your Dealership Management System Provider (DMS)'),
            Forms\Components\TextInput::make('backups')
                ->label('Where and how are backups being stored?'),
            Forms\Components\Repeater::make('website_urls')
                ->schema([
                    Forms\Components\TextInput::make('url'),
                ])->createItemButtonLabel('Add Website URL'),
            Forms\Components\TextInput::make('designated_red_flag_coordinator')
                ->label('Who is your designated Red Flag Coordinator?'),
            Radio::make('document_shredding')
                ->options([
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->label('Do you use a document Shredding Company?'),
            Radio::make('service_provider_agreements')
                ->options([
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->label('Are Service Provider Agreements & Risk Assessments on file with your dealership?'),
            Radio::make('offsite_storage')
                ->options([
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->label('Does your dealership store any customer information at offsite locations?'),
            Radio::make('other_business')
                ->options([
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->label('Does your dealership have an affiliation with any other business where he/she has a financial interest of more than 25%?'),
            Radio::make('vendor_access')
                ->options([
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->label('Are there any vendors that have after hour access to your dealership and other buildings storing customer information?'),
            Radio::make('personal_devices')
                ->options([
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->label('Are there any persons that have customers access on their personal PC or that maintain a customer data base on their personal device of any kind?'),
            Radio::make('compliance_issues')
                ->options([
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->label('Have there been any compliance related issues that Automotive Risk Management Partners should be made aware of i.e. Information being compromised, fraud attempted on the dealership etc.'),
        ];
    }

    public function update(): void
    {
        $this->dealer->update($this->form->getState());

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
