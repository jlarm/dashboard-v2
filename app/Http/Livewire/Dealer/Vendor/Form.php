<?php

namespace App\Http\Livewire\Dealer\Vendor;

use App\Models\Dealer\Vendor;
use Livewire\Component;

class Form extends Component
{
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

    public Vendor $vendor;

    protected $rules = [
        'contact_name' => 'required',
        'signature' => 'required',
        'q1a' => 'required',
        'q1c' => 'nullable',
        'q2a' => 'required',
        'q2c' => 'nullable',
        'q3a' => 'required',
        'q3c' => 'nullable',
        'q4a' => 'required',
        'q4c' => 'nullable',
        'q5a' => 'required',
        'q5c' => 'nullable',
        'q6a' => 'required',
        'q6c' => 'nullable',
        'q7a' => 'required',
        'q7c' => 'nullable',
        'q8a' => 'required',
        'q8c' => 'nullable',
        'q9a' => 'required',
        'q9c' => 'nullable',
        'q10a' => 'required',
        'q10c' => 'nullable',
        'q11a' => 'required',
        'q11c' => 'nullable',
        'q12a' => 'required',
        'q12c' => 'nullable',
        'q13a' => 'required',
        'q13c' => 'nullable',
        'q14a' => 'required',
        'q14c' => 'nullable',
        'q15a' => 'required',
        'q15c' => 'nullable',
        'q16a' => 'required',
        'q16c' => 'nullable',
        'q17a' => 'required',
        'q17c' => 'nullable',
        'q18a' => 'required',
        'q18c' => 'nullable',
        'q19a' => 'required',
        'q19c' => 'nullable',
        'q20a' => 'required',
        'q20c' => 'nullable',
        'q21a' => 'required',
        'q21c' => 'nullable',
        'q22a' => 'required',
        'q22c' => 'nullable',
    ];

    public function submit()
    {
        $validated = $this->validate();
        \Storage::put('signatures/'.tenant('name').'/'.$this->contact_name.now().'.png', base64_decode(\Str::of($this->signature)->after(',')));
        dd($validated);
    }

    public function render()
    {
        return view('livewire.dealer.vendor.form');
    }
}
