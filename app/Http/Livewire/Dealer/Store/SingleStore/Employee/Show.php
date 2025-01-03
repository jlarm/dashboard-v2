<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class Show extends Component
{
    public Store $store;

    public User $user;

    public function render(): View
    {
        return view('livewire.dealer.store.single-store.employee.show', [
            'isQi' => $this->user->roles->contains('name', 'Qualified Individual'),
            'roles' => $this->user->roles->whereNotIn('name', ['Qualified Individual'])->pluck('name')->toArray(),
        ])->layout('components.dealer-app');
    }
}
