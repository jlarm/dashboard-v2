<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Department;

use App\Models\Department;
use Livewire\Component;

class IndexItem extends Component
{
    public Department $department;

    public function render()
    {
        return view('livewire.central.department.index-item');
    }
}
