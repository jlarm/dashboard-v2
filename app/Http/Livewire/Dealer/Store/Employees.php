<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Livewire\Component;

class Employees extends Component
{
    public Store $store;
    public $sid = '';

    public function mount()
    {
        $this->sid = $this->store->id;
    }

    public function render()
    {
        return view('livewire.dealer.store.employees', [
            'users' => Store::where('id', $this->sid)->first()->users()
                ->with('roles')
                ->with('department')
                ->get(),
        ]);
    }
}
