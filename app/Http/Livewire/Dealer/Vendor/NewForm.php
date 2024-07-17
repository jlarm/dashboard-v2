<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Store;
use App\Models\Dealer\VendorForm;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class NewForm extends Component
{
    public $vid;

    public $vendor;

    public $data = [];

    public $signature;

    public $storeName;

    public $qis;

    protected $queryString = ['vid'];

    protected $rules = [
        'data.*.response' => 'required',
    ];

    public function mount()
    {
        $this->vendor = VendorForm::findOrFail($this->vid);

        $this->qis = User::role('Qualified Individual')->get();

        $this->storeName = $this->vendor->vendor->store->name ?? Store::first()->name;

        $this->data[1]['question'] = 'Are you an employee or authorized representative of this vendor/company? Indicate the Person’s Name in the comments.';
        $this->data[2]['question'] = 'Does your company offer software applications as part of its services?';
        $this->data[3]['question'] = 'Is client data encrypted at rest and in transit? If not, why not?';
        $this->data[4]['question'] = 'Has your company experienced a data breach in the past 12 months that affected customers’ personal information?';
        $this->data[5]['question'] = 'Does your company have insurance coverage for a data breach that may involve our customers’ information that your company acquires while doing business with us?';
        $this->data[6]['question'] = 'Does your company require security awareness training for all employees? If so, please answer how often it is provided in the comments section.';
        $this->data[7]['question'] = 'Does your company monitor for the effectiveness of employee security training by testing your users with simulated attacks?';
        $this->data[8]['question'] = 'Does your company have a process for restricting access to customer files on a need-to-know basis?';
        $this->data[9]['question'] = 'Do you have a written information security program?';
        $this->data[10]['question'] = 'Does your company conduct annual risk assessments that assess electronic, physical, and administrative information safeguards?';
        $this->data[11]['question'] = 'Does your company have systems in place to securely dispose of documents that have personal identifiable information on them?';
        $this->data[12]['question'] = 'Does your company have systems in place to restrict access to files/documents containing customers personal information to those with proper authorization?';
        $this->data[13]['question'] = 'Does your company have due diligence processes and procedures for vetting subcontractors, including having them sign processing agreements that are compliant with applicable federal and state laws?';
        $this->data[14]['question'] = 'Has your company performed penetration testing of its systems within the past 12 months?';
        $this->data[15]['question'] = 'Has your company conducted a vulnerability assessment of your systems within the past 6 months?';
        $this->data[16]['question'] = 'Does your company maintain end-of-life or unsupported operating systems or software? If so, are these systems used to manage or maintain customer data?';
        $this->data[17]['question'] = 'Does your company regularly patch or update systems and third-party software and monitor for noncompliance?';
        $this->data[18]['question'] = 'Does your company have a written incident response plan in the event of a security breach?';
        $this->data[19]['question'] = 'Does your company require users to create complex passwords with 9 characters or greater?';
        $this->data[20]['question'] = 'Does your company prohibit shared logins?';
        $this->data[21]['question'] = 'Does your company require multi-factor authentication to log into your company’s systems?';
        $this->data[22]['question'] = 'Do you have an account lockout policy?';
    }

    public function submit()
    {
        $this->validate();

        $fName = \Str::of($this->vendor->name)->replace(' ', '')->lower();
        $cTime = now()->format('YmdHis');
        $fileName = $fName.$cTime.'.png';

        $this->vendor->update([
            'data' => $this->data,
            'signature' => $fileName,
        ]);

        \Storage::put('signatures/'.$fileName, base64_decode(explode(',', $this->signature)[1]));

        foreach ($this->qis as $qi) {
            Notification::send($qi, new \App\Notifications\VendorSignedNotification($this->vendor));
        }

        return redirect(route('dealer.vendors.thankyou'));
    }

    public function render()
    {
        return view('livewire.dealer.vendor.new-form')->layout('layouts.guest');
    }
}
