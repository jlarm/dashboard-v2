<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector;

class Create extends Component
{
    public string $contractType = '';
    public string $agreementDate = '';
    public string $dealerName = '';

    /** @var array<int, string> */
    public array $services = [];

    public string $commenceDate = '';
    public int $yearlyInspectionTotal;
    public int $initialFee;
    public int $monthlyFee;
    public ?string $armpSignature = null;
    public ?string $armpPrintedName = null;
    public ?string $armpDateSigned = null;
    public ?string $dealerPhysicalAddress = null;
    public ?string $dealerPhysicalCity = null;
    public ?string $dealerPhysicalState = null;
    public ?string $dealerPhysicalZip = null;
    public ?string $dealerPhone = null;
    public ?string $dealerQiName = null;
    public ?string $dealerQiPhone = null;
    public ?string $dealerQiEmail = null;
    public ?string $dealerBillingAddress = null;
    public ?string $dealerBillingCity = null;
    public ?string $dealerBillingState = null;
    public ?string $dealerBillingZip = null;
    public ?string $dealerBillingFax = null;
    public ?string $dealerBillingContactName = null;
    public ?string $dealerBillingContactTitle = null;
    public ?string $dealerBillingContactEmail = null;

    /** @var Collection<int, array<string, string>> */
    public Collection $additionalLocations;

    /** @var array<string, string> */
    protected $rules = [
        'contractType' => 'required|string',
        'agreementDate' => 'required|date',
        'dealerName' => 'required|string',
        'services' => 'required|min:1|array',
        'services.*' => 'required|string',
        'commenceDate' => 'required|date',
        'yearlyInspectionTotal' => 'required|numeric',
        'initialFee' => 'required',
        'monthlyFee' => 'required',
        'dealerPhysicalAddress' => 'nullable|string',
        'dealerPhysicalCity' => 'nullable|string',
        'dealerPhysicalState' => 'nullable|string',
        'dealerPhysicalZip' => 'nullable|string',
        'dealerPhone' => 'nullable|string',
        'dealerQiName' => 'nullable|string',
        'dealerQiEmail' => 'nullable|email',
        'dealerBillingAddress' => 'nullable|string',
        'dealerBillingCity' => 'nullable|string',
        'dealerBillingState' => 'nullable|string',
        'dealerBillingZip' => 'nullable|string',
        'dealerBillingFax' => 'nullable|string',
        'dealerBillingContactName' => 'nullable|string',
        'dealerBillingContactTitle' => 'nullable|string',
        'dealerBillingContactEmail' => 'nullable|email',
        'additionalLocations.*.name' => 'required|string',
        'additionalLocations.*.address' => 'required|string',
        'additionalLocations.*.city' => 'required|string',
        'additionalLocations.*.state' => 'required|string',
        'additionalLocations.*.zip' => 'required|string',
        'additionalLocations.*.contact_name' => 'nullable|string',
        'additionalLocations.*.contact_title' => 'nullable|string',
        'additionalLocations.*.contact_email' => 'nullable|email',
    ];

    public function mount(): void
    {
        $this->additionalLocations = collect();
    }

    public function addLocation(): void
    {
        $this->additionalLocations->push([
            'name' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'contact_name' => '',
            'contact_title' => '',
            'contact_email' => '',
        ]);
    }

    public function removeLocation(int $locationKey): void
    {
        $this->additionalLocations->pull($locationKey);
    }

    public function create(): Redirector|RedirectResponse
    {
        $this->validate();

        $contract = Contract::query()->create([
            'contract_type' => $this->contractType,
            'agreement_date' => $this->agreementDate,
            'dealer_name' => Str::title($this->dealerName),
            'services' => json_encode($this->services, JSON_THROW_ON_ERROR),
            'commence_date' => $this->commenceDate,
            'yearly_inspection_total' => $this->yearlyInspectionTotal,
            'initial_fee' => $this->initialFee,
            'monthly_fee' => $this->monthlyFee,
            'dealer_physical_address' => $this->dealerPhysicalAddress,
            'dealer_physical_city' => $this->dealerPhysicalCity,
            'dealer_physical_state' => $this->dealerPhysicalState,
            'dealer_physical_zip' => $this->dealerPhysicalZip,
            'dealer_phone' => $this->dealerPhone,
            'dealer_qi_name' => $this->dealerQiName,
            'dealer_qi_email' => $this->dealerQiEmail,
            'dealer_billing_address' => $this->dealerBillingAddress,
            'dealer_billing_city' => $this->dealerBillingCity,
            'dealer_billing_state' => $this->dealerBillingState,
            'dealer_billing_zip' => $this->dealerBillingZip,
            'dealer_billing_fax' => $this->dealerBillingFax,
            'dealer_billing_contact_name' => $this->dealerBillingContactName,
            'dealer_billing_contact_title' => $this->dealerBillingContactTitle,
            'dealer_billing_contact_email' => $this->dealerBillingContactEmail,
            'additional_locations' => $this->additionalLocations->all(),
        ]);

        $contract->status()->create([
            'name' => auth()->user()?->name ?? '',
            'status' => 'created contract',
            'step' => 1,
        ]);

        Notification::make()
            ->title('Contract Created')
            ->success()
            ->send();

        return to_route('contracts.edit', $contract);

    }

    public function render(): View
    {
        return view('livewire.central.contracts.create');
    }
}
