<?php

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Livewire\Component;
use Storage;
use Str;

class Review extends Component
{
    public Contract $contract;
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
    public $dealerPrintedName;
    public $dealerDateSigned;
    public $dealerSignature;

    protected $rules = [
        'dealerPhysicalAddress' => 'required|string|max:255',
        'dealerPhysicalCity' => 'required|string|max:255',
        'dealerPhysicalState' => 'required|string|max:255',
        'dealerPhysicalZip' => 'required|string|max:255',
        'dealerPhone' => 'required|string|max:255',
        'dealerQiName' => 'required|string|max:255',
        'dealerQiEmail' => 'required|string|max:255',
        'dealerBillingAddress' => 'required|string|max:255',
        'dealerBillingCity' => 'required|string|max:255',
        'dealerBillingState' => 'required|string|max:255',
        'dealerBillingZip' => 'required|string|max:255',
        'dealerBillingFax' => 'nullable',
        'dealerBillingContactName' => 'required|string|max:255',
        'dealerBillingContactTitle' => 'required|string|max:255',
        'dealerBillingContactEmail' => 'required|string|max:255',
        'dealerPrintedName' => 'required|string|max:255',
        'dealerSignature' => 'required',
    ];

    public function mount()
    {
        if ($this->contract->dealer_printed_name) {
            return redirect()->to('thank-you');
        }

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

    public function submit()
    {
        $this->validate();

        if ($this->dealerPrintedName != '' && $this->dealerSignature) {
            $name = Str::of($this->dealerPrintedName)->replace(' ', '-')->lower();
            $time = now()->format('Y-m-d-H-i-s');
            $filename = "contracts/{$this->contract->uuid}/{$name}-{$time}.png";
            Storage::disk('public')->put($filename, base64_decode(Str::of($this->dealerSignature)->after(',') ));

            $this->contract->update([
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
                'dealer_printed_name' => $this->dealerPrintedName,
                'dealer_date_signed' => now(),
                'dealer_signature' => $filename,
                'status' => 'pending',
            ]);

            $this->contract->status()->create([
                'name' => $this->contract->dealer_printed_name,
                'status' => 'signed the contract',
                'step' => 3,
            ]);

            \Notification::route('mail', $this->contract->user->email)
                ->notify(new \App\Notifications\ContractSignedNotification($this->contract));

            \Notification::route('mail', 'tdortch@autorisknow.com')
                ->notify(new \App\Notifications\ContractSignedNotification($this->contract));

            return redirect()->to('thank-you');
        }

    }

    public function reviewLabel($service): string
    {
        return match ($service) {
            'glba' => 'GLBA - Safeguards Rule, Sales & Finance',
            'osha' => 'OSHA',
            'it' => 'IT Security',
            'ces' => 'Cyber Enhanced Security',
        };
    }

    public function render()
    {
        return view('livewire.central.contracts.review', [
            'services' => json_decode($this->contract->services),
        ])->layout('layouts.guest');
    }
}
