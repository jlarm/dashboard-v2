<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use Illuminate\Http\Request;
use Livewire\Component;

class Create extends Component
{
    public $store;

    public function mount(Request $request)
    {
        $this->store = $request->get('store') ?? '';
    }

    public function render()
    {
        return view('livewire.dealer.store.single-store.employee.create')->layout('components.dealer-app');
    }
}
