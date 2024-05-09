<?php

namespace App\Http\Livewire\Central\Contracts;

use App\Jobs\GenerateContractPdfJob;
use App\Models\Contract;
use Livewire\Component;
use Notification;
use Storage;
use Str;

class Edit extends Component
{
    public Contract $contract;
    public $agreementDate;
    public $dealerName;
    public $services = [];
    public $commenceDate;
    public $yearlyInspectionTotal;
    public $initialFee;
    public $monthlyFee;
    public $armpSignature;
    public $armpPrintedName;
    public $dealerPhysicalAddress;
    public $dealerPhysicalCity;
    public $dealerPhysicalState;
    public $dealerPhysicalZip;
    public $dealerPhone;
    public $dealerQiName;
    public $dealerQiEmail;
    public $dealerBillingAddress;
    public $dealerBillingCity;
    public $dealerBillingState;
    public $dealerBillingZip;
    public $dealerBillingFax;
    public $dealerBillingContactName;
    public $dealerBillingContactTitle;
    public $dealerBillingContactEmail;

    protected $listeners = ['contractUpdated' => '$refresh'];

    public function mount()
    {
        $this->agreementDate = $this->contract->agreement_date->format('Y-m-d');
        $this->dealerName = $this->contract->dealer_name;
        $this->services = json_decode($this->contract->services);
        $this->commenceDate = $this->contract->commence_date->format('Y-m-d');
        $this->yearlyInspectionTotal = $this->contract->yearly_inspection_total;
        $this->initialFee = number_format($this->contract->initial_fee, 2);
        $this->monthlyFee = number_format($this->contract->monthly_fee, 2);
        $this->armpSignature = $this->contract->armp_signature;
        $this->armpPrintedName = $this->contract->armp_printed_name;
        $this->dealerPhysicalAddress = $this->contract->dealer_physical_address;
        $this->dealerPhysicalCity = $this->contract->dealer_physical_city;
        $this->dealerPhysicalState = $this->contract->dealer_physical_state;
        $this->dealerPhysicalZip = $this->contract->dealer_physical_zip;
        $this->dealerPhone = $this->contract->dealer_phone;
        $this->dealerQiName = $this->contract->dealer_qi_name;
        $this->dealerQiEmail = $this->contract->dealer_qi_email;
        $this->dealerBillingAddress = $this->contract->dealer_billing_address;
        $this->dealerBillingCity = $this->contract->dealer_billing_city;
        $this->dealerBillingState = $this->contract->dealer_billing_state;
        $this->dealerBillingZip = $this->contract->dealer_billing_zip;
        $this->dealerBillingFax = $this->contract->dealer_billing_fax;
        $this->dealerBillingContactName = $this->contract->dealer_billing_contact_name;
        $this->dealerBillingContactTitle = $this->contract->dealer_billing_contact_title;
        $this->dealerBillingContactEmail = $this->contract->dealer_billing_contact_email;
    }

    protected $rules = [
        'agreementDate' => 'required|date',
        'dealerName' => 'required|string',
        'services.*' => 'required|string',
        'commenceDate' => 'required|date',
        'yearlyInspectionTotal' => 'required|numeric',
        'initialFee' => 'required|numeric',
        'monthlyFee' => 'required|numeric',
        'armpSignature' => 'nullable|string',
        'armpPrintedName' => 'nullable|string',
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
    ];

    public function update()
    {
        $this->contract->update([
            'agreement_date' => $this->agreementDate,
            'dealer_name' => $this->dealerName,
            'services' => json_encode($this->services),
            'commence_date' => $this->commenceDate,
            'yearly_inspection_total' => $this->yearlyInspectionTotal,
            'initial_fee' => $this->initialFee,
            'monthly_fee' => $this->monthlyFee,
            'armp_printed_name' => $this->armpPrintedName,
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
        ]);

        if ($this->contract->armp_printed_name != '' && $this->armpSignature) {
            $name = Str::of($this->armpPrintedName)->replace(' ', '-')->lower();
            $time = now()->format('Y-m-d-H-i-s');
            $filename = "contracts/{$this->contract->uuid}/{$name}-{$time}.png";
            Storage::disk('public')->put($filename, base64_decode(Str::of($this->armpSignature)->after(',') ));

            $this->contract->update([
                'armp_signature' => $filename,
                'armp_date_signed' => now(),
            ]);

            $this->contract->status()->create([
                'name' => auth()->user()->name,
                'status' => 'uploaded signature',
                'step' => 4,
            ]);
        }

        $this->contract->status()->create([
            'name' => auth()->user()->name,
            'status' => 'updated contract'
        ]);

        \Filament\Notifications\Notification::make()
            ->title('Contract Updated')
            ->success()
            ->send();

        $this->emit('contractUpdated');
    }

    public function render()
    {
        return view('livewire.central.contracts.edit');
    }
}
