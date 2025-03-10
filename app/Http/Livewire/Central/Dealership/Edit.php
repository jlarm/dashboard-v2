<?php

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use App\Models\User;
use Illuminate\View\View;
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

    public $users;

    public array $selectedUsers = [];

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
        'locations' => 'boolean',
        'users' => 'array',
    ];

    public function mount(Dealership $dealership): void
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
        $this->locations = (bool) $dealership->locations;
        $this->users = User::orderBy('name')->get();
        $this->selectedUsers = $this->dealership->users->toArray();
    }

    public function removeUser($userId): void
    {
        $this->selectedUsers = array_filter($this->selectedUsers, function ($user) use ($userId) {
            return $user['id'] !== $userId;
        });
    }

    public function updateDealership(): void
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
        ]);

        $this->dealership->users()->sync(collect($this->selectedUsers)->pluck('id'));

        $this->close();
    }

    public function render(): View
    {
        return view('livewire.central.dealership.edit');
    }
}
