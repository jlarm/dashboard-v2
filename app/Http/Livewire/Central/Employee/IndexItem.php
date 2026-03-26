<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Employee;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public User $user;
    public int $totalCourses;
    public int $completed;

    public function mount(int $totalCourses, int $completed): void
    {
        $this->totalCourses = $totalCourses;
        $this->completed = $completed;
    }

    public function render(): View
    {
        return view('livewire.central.employee.index-item');
    }
}
