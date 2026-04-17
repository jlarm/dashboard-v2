<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Override;

class Details extends Component
{
    public User $user;

    #[Override]
    protected $listeners = ['refreshEmployeeDetails' => '$refresh'];

    public function roles()
    {
        return $this->user->roles->whereNotIn('name', ['Qualified Individual'])->pluck('name')->toArray();
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.employee.details');
    }
}
