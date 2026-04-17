<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Employees extends Component
{
    public Store $store;
    public $sid = '';

    public function mount(): void
    {
        $this->sid = $this->store->id;
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.store.employees', [
            'users' => Store::query()->where('id', $this->sid)->first()->users()
                ->with('roles')
                ->with('department')
                ->get(),
        ]);
    }
}
