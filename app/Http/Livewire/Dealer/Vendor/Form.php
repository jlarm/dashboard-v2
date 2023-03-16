<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Vendor;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public Vendor $vendor;

    public $name;

    public $contact_name;

    public $signature;

    public $q1a;

    public $q1c;

    public $q2a;

    public $q2c;

    public $q3a;

    public $q3c;

    public $q4a;

    public $q4c;

    public $q5a;

    public $q5c;

    public $q6a;

    public $q6c;

    public $q7a;

    public $q7c;

    public $q8a;

    public $q8c;

    public $q9a;

    public $q9c;

    public $q10a;

    public $q10c;

    public $q11a;

    public $q11c;

    public $q12a;

    public $q12c;

    public $q13a;

    public $q13c;

    public $q14a;

    public $q14c;

    public $q15a;

    public $q15c;

    public $q16a;

    public $q16c;

    public $q17a;

    public $q17c;

    public $q18a;

    public $q18c;

    public $q19a;

    public $q19c;

    public $q20a;

    public $q20c;

    public $q21a;

    public $q21c;

    public $q22a;

    public $q22c;

    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'contact_name' => ['required', 'string', 'max:255'],
        'q1a' => ['required', 'string', 'max:255'],
        'q1c' => ['nullable', 'string', 'max:255'],
        'q2a' => ['required', 'string', 'max:255'],
        'q2c' => ['nullable', 'string', 'max:255'],
        'q3a' => ['required', 'string', 'max:255'],
        'q3c' => ['nullable', 'string', 'max:255'],
        'q4a' => ['required', 'string', 'max:255'],
        'q4c' => ['nullable', 'string', 'max:255'],
        'q5a' => ['required', 'string', 'max:255'],
        'q5c' => ['nullable', 'string', 'max:255'],
        'q6a' => ['required', 'string', 'max:255'],
        'q6c' => ['nullable', 'string', 'max:255'],
        'q7a' => ['required', 'string', 'max:255'],
        'q7c' => ['nullable', 'string', 'max:255'],
        'q8a' => ['required', 'string', 'max:255'],
        'q8c' => ['nullable', 'string', 'max:255'],
        'q9a' => ['required', 'string', 'max:255'],
        'q9c' => ['nullable', 'string', 'max:255'],
        'q10a' => ['required', 'string', 'max:255'],
        'q10c' => ['nullable', 'string', 'max:255'],
        'q11a' => ['required', 'string', 'max:255'],
        'q11c' => ['nullable', 'string', 'max:255'],
        'q12a' => ['required', 'string', 'max:255'],
        'q12c' => ['nullable', 'string', 'max:255'],
        'q13a' => ['required', 'string', 'max:255'],
        'q13c' => ['nullable', 'string', 'max:255'],
        'q14a' => ['required', 'string', 'max:255'],
        'q14c' => ['nullable', 'string', 'max:255'],
        'q15a' => ['required', 'string', 'max:255'],
        'q15c' => ['nullable', 'string', 'max:255'],
        'q16a' => ['required', 'string', 'max:255'],
        'q16c' => ['nullable', 'string', 'max:255'],
        'q17a' => ['required', 'string', 'max:255'],
        'q17c' => ['nullable', 'string', 'max:255'],
        'q18a' => ['required', 'string', 'max:255'],
        'q18c' => ['nullable', 'string', 'max:255'],
        'q19a' => ['required', 'string', 'max:255'],
        'q19c' => ['nullable', 'string', 'max:255'],
        'q20a' => ['required', 'string', 'max:255'],
        'q20c' => ['nullable', 'string', 'max:255'],
        'q21a' => ['required', 'string', 'max:255'],
        'q21c' => ['nullable', 'string', 'max:255'],
        'q22a' => ['required', 'string', 'max:255'],
        'q22c' => ['nullable', 'string', 'max:255'],
        'signature' => ['required'],
    ];

    public function mount(Vendor $vendor)
    {
        $this->vendor = $vendor;
        $this->name = $vendor->name;
        $this->contact_name = $vendor->contact_name;
    }

    public function submit()
    {
        $validated = $this->validate();
        $fName = \Str::of($this->contact_name)->replace(' ', '')->lower();
        $cTime = now()->format('YmdHis');
        $fileName = $fName.$cTime.'.png';

        $this->vendor->update([
            'q1a' => $this->q1a,
            'q1c' => $this->q1c,
            'q2a' => $this->q2a,
            'q2c' => $this->q2c,
            'q3a' => $this->q3a,
            'q3c' => $this->q3c,
            'q4a' => $this->q4a,
            'q4c' => $this->q4c,
            'q5a' => $this->q5a,
            'q5c' => $this->q5c,
            'q6a' => $this->q6a,
            'q6c' => $this->q6c,
            'q7a' => $this->q7a,
            'q7c' => $this->q7c,
            'q8a' => $this->q8a,
            'q8c' => $this->q8c,
            'q9a' => $this->q9a,
            'q9c' => $this->q9c,
            'q10a' => $this->q10a,
            'q10c' => $this->q10c,
            'q11a' => $this->q11a,
            'q11c' => $this->q11c,
            'q12a' => $this->q12a,
            'q12c' => $this->q12c,
            'q13a' => $this->q13a,
            'q13c' => $this->q13c,
            'q14a' => $this->q14a,
            'q14c' => $this->q14c,
            'q15a' => $this->q15a,
            'q15c' => $this->q15c,
            'q16a' => $this->q16a,
            'q16c' => $this->q16c,
            'q17a' => $this->q17a,
            'q17c' => $this->q17c,
            'q18a' => $this->q18a,
            'q18c' => $this->q18c,
            'q19a' => $this->q19a,
            'q19c' => $this->q19c,
            'q20a' => $this->q20a,
            'q20c' => $this->q20c,
            'q21a' => $this->q21a,
            'q21c' => $this->q21c,
            'q22a' => $this->q22a,
            'q22c' => $this->q22c,
            'signature' => $fileName,
        ]);

        \Storage::put('signatures/'.$fileName, base64_decode(\Str::of($this->signature)->after(',')));

        return redirect(route('dealer.vendors.thankyou'));

    }

    public function render(): View
    {
        return view('livewire.dealer.vendor.form');
    }
}
