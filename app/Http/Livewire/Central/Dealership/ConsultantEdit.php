<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Dealership;

use App\Models\Dealership;
use WireElements\Pro\Components\SlideOver\SlideOver;

class ConsultantEdit extends SlideOver
{
    public $dealership;
    public $name;
    public $domain;
    public $url;
    public $locations;
    protected $rules = [
        'name' => 'required',
        'domain' => 'required',
        'url' => 'required',
        'locations' => 'required',
    ];

    public function mount(Dealership $dealership): void
    {
        $this->dealership = $dealership;
        $this->name = $dealership->name;
        $this->domain = $dealership->domain;
        $this->url = $dealership->url;
        $this->locations = $dealership->locations;
    }

    public function updateDealership(): void
    {
        $this->dealership->update([
            'name' => $this->name,
            'domain' => $this->domain,
            'url' => $this->url,
            'locations' => $this->locations,
        ]);

        $this->emit('refreshDealerships');

        $this->close();
    }

    public function render()
    {
        return view('livewire.central.dealership.consultant-edit');
    }
}
