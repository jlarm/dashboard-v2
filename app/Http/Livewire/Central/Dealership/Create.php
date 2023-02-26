<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use App\Models\User;
use Hash;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $address;
    public $city;
    public $state;
    public $zip_code;
    public $phone;
    public $fax;

    public $domain;

    public $url;

    public $locations;

    public $password;

    protected $rules = [
        'name' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zip_code' => 'required',
        'phone' => 'required',
        'fax' => 'nullable',
        'domain' => 'required|unique:domains',
        'url' => 'required|url',
        'locations' => 'nullable|boolean',
        'password' => 'required',
    ];

    public function createDealer()
    {
        $validated = $this->validate();

        $tenantDomain = $validated['domain'].'.'.config('tenancy.central_domains')[0];

        $dealer = Dealership::create([
            'user_id' => auth()->user()->id,
            'name' => $validated['name'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip_code' => $validated['zip_code'],
            'phone' => $validated['phone'],
            'fax' => $validated['fax'],
            'domain' => $tenantDomain,
            'url' => $validated['url'],
            'locations' => $validated['locations'],
        ]);

        $dealer->createDomain($tenantDomain, $validated['url']);

        $dealer->run(function () {
            $user = User::create([
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->phone,
                'password' => Hash::make($this->password),
            ]);
            $user->assignRole('Consultant');
        });

        return redirect(route('central.dealership.index'));

    }
}
