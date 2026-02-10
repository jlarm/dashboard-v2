<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Department;

use App\Models\Dealer\Department;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $department;

    public function mount(Department $department): void
    {
        $this->department = $department;
    }

    public function delete()
    {
        $this->department->courses()->detach();
        $this->department->delete();

        Notification::make()
            ->title('Department Deleted Successfully!')
            ->success()
            ->send();

        return redirect()->route('department.index');
    }

    public function render()
    {
        return view('livewire.central.department.delete');
    }
}
