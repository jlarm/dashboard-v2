<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use App\Models\User;
use WireElements\Pro\Components\SlideOver\SlideOver;

class Edit extends SlideOver
{
    public $dealership;
    public $address;
    public $city;
    public $state;
    public $zip_code;
    public $phone;
    public $fax;

    public $name;

    public $domain;

    public $url;

    public $locations;

    public $user;

    public function mount(Dealership $dealership)
    {
        $this->dealership = $dealership;
        $this->address = $dealership->address;
        $this->city = $dealership->city;
        $this->state = $dealership->state;
        $this->zip_code = $dealership->zip_code;
        $this->phone = $dealership->phone;
        $this->fax = $dealership->fax;
        $this->name = $dealership->name;
        $this->domain = $dealership->domain;
        $this->url = $dealership->url;
        $this->locations = $dealership->locations;
        $this->user = $dealership->user_id;
    }

    protected $rules = [
        'name' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zip_code' => 'required',
        'phone' => 'required',
        'fax' => 'nullable',
        'domain' => 'required',
        'url' => 'required',
        'locations' => 'required',
        'user' => 'required',
    ];

    public function updateDealership()
    {
        $this->dealership->update([
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'domain' => $this->domain,
            'url' => $this->url,
            'locations' => $this->locations,
            'user_id' => $this->user,
        ]);

        $this->emit('refreshDealerships');

        $this->close();
    }

    public function render()
    {
        return view('livewire.central.dealership.edit', [
            'users' => User::latest()->get(),
        ]);
    }
}
