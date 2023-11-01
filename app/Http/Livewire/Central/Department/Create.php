<?php

namespace App\Http\Livewire\Central\Department;

use App\Models\Department;
use Filament\Notifications\Notification;
use Livewire\Component;

class Create extends Component
{
    public $name;

    protected $rules = [
        'name' => 'required|unique:departments,name',
    ];

    public function create()
    {
        $this->validate();

        Department::create(['name' => $this->name]);

        $this->reset();

        $this->emit('departmentCreated');

        Notification::make()
            ->title('Department Successfully Created!')
            ->success()
            ->send();
    }
    public function render()
    {
        return view('livewire.central.department.create');
    }
}
