<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ManagerIndexItem extends Component
{
    public User $user;

    public function render(): Factory|View
    {
        return view('livewire.dealer.employee.manager-index-item');
    }
}
