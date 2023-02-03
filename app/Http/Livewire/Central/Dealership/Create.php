<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use App\Models\User;
use Hash;
use WireElements\Pro\Components\Modal\Modal;

class Create extends Modal
{
    public $name;
    public $domain;
    public $url;
    public $locations;
    public $password;

    protected $rules = [
        'name' => 'required',
        'domain' => 'required|unique:domains',
        'url' => 'required|url',
        'locations' => 'nullable|boolean',
        'password' => 'required',
    ];

    public function createDealer()
    {
        $validated = $this->validate();

        $tenantDomain = $validated['domain'] . '.' . config('tenancy.central_domains')[0];

        $dealer = Dealership::create([
            'user_id' => auth()->user()->id,
            'name' => $validated['name'],
            'domain' => $tenantDomain,
            'url' => $validated['url'],
            'locations' => $validated['locations'],
        ]);
        $dealer->createDomain($tenantDomain);

        $dealer->run(function () {
            $user = User::create([
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->phone,
                'password' => Hash::make($this->password),
            ]);
            $user->assignRole('Consultant');
        });

        $this->emit('refreshDealerships');

        $this->close();
    }
    public function render()
    {
        return view('livewire.central.dealership.create');
    }

    private function merge(array $array)
    {
    }
}
