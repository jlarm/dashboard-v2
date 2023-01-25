<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use WireElements\Pro\Components\Modal\Modal;

class Create extends Modal
{
    public $name;
    public $domain;
    public $url;
    public $locations;

    protected $rules = [
        'name' => 'required',
        'domain' => 'required|unique:domains',
        'url' => 'required|url',
        'locations' => 'nullable|boolean',
    ];

    public function createDealer()
    {
        $validated = $this->validate();

        $tenantDomain = $validated['domain'] . '.' . config('tenancy.central_domains')[0];

        $dealer = Dealership::create([
            'user_id' => auth()->user()->id,
            'name' => $validated['name'],
            'domain' => $validated['domain'],
            'url' => $validated['url'],
            'locations' => $validated['locations'],
        ]);
        $dealer->createDomain($tenantDomain);

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
