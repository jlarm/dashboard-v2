<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Models\Dealer\Store;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public Store $store;

    public $sid = '';

    public function mount()
    {
        $this->sid = $this->store->id;
    }
    public function render()
    {
        return view('livewire.dealer.store.single-store.employee.index', [
            'users' => Store::where('id', $this->sid)->first()->users()
                ->with('roles')
                ->with('department')
                ->get(),
        ])->layout('components.dealer-app');
    }
}
