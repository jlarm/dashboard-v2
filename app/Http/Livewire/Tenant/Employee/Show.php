<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Employee;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class Show extends Component
{
    public User $user;
    public bool $isQi;
    public array $roles = [];

    public function mount(): void
    {
        $this->isQi = $this->user->roles->contains('name', 'Qualified Individual');
        $this->roles = $this->user->roles->whereNotIn('name', ['Qualified Individual'])->pluck('name')->toArray();
    }

    public function render(): View
    {
        return view('livewire.tenant.employee.show')->layout('components.dealer-app');
    }
}
