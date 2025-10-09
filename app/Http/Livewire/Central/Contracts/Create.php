<?php

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public $contractType;
    public $agreementDate;
    public $dealerName;
    public $services = [];
    public $commenceDate;
    public $yearlyInspectionTotal;
    public $initialFee;
    public $monthlyFee;
    public $armpSignature;
    public $armpPrintedName;
    public $armpDateSigned;
    public $dealerPhysicalAddress;
    public $dealerPhysicalCity;
    public $dealerPhysicalState;
    public $dealerPhysicalZip;
    public $dealerPhone;
    public $dealerQiName;
    public $dealerQiPhone;
    public $dealerQiEmail;
    public $dealerBillingAddress;
    public $dealerBillingCity;
    public $dealerBillingState;
    public $dealerBillingZip;
    public $dealerBillingFax;
    public $dealerBillingContactName;
    public $dealerBillingContactTitle;
    public $dealerBillingContactEmail;
    public Collection $additionalLocations;
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

    public function mount()
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

    public function removeLocation($locationKey): void
    {
        $this->additionalLocations->pull($locationKey);
    }

    public function create()
    {
        $this->validate();

        $contract = Contract::create([
            'contract_type' => $this->contractType,
            'agreement_date' => $this->agreementDate,
            'dealer_name' => Str::title($this->dealerName),
            'services' => json_encode($this->services),
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
            'additional_locations' => $this->additionalLocations->toArray(),
        ]);

        $contract->status()->create([
            'name' => auth()->user()->name,
            'status' => 'created contract',
            'step' => 1,
        ]);

        Notification::make()
            ->title('Contract Created')
            ->success()
            ->send();

        return redirect()->route('contracts.edit', $contract);

    }

    public function render()
    {
        return view('livewire.central.contracts.create');
    }
}
