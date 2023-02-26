<?php

namespace App\Http\Livewire\Dealer\Vendor;

use Creagia\LaravelSignPad\Concerns\RequiresSignature;
use Creagia\LaravelSignPad\Contracts\CanBeSigned;
use Livewire\Component;

class Form extends Component implements CanBeSigned
{
    use RequiresSignature;
    public $contact_name;
    public $qia;
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

    public function render()
    {
        return view('livewire.dealer.vendor.form');
    }
}
