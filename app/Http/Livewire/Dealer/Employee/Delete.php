<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Store;
use App\Models\User;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public Store $store;

    public $user;

    public function mount(User $user)
    {
        $this->store = Store::find(app('currentStore'));
        $this->user = $user;
    }

    public function delete()
    {
        try {
            $this->user->delete();

            Notification::make()
                ->title('Employee Deleted Successfully!')
                ->success()
                ->send();

            return tenant('locations') ? redirect()->route('dealer.stores.employees', $this->store) : redirect()->route('dealer.employees.index');
        } catch (\Exception $e) {
            \Log::error($e);
            $this->addError('file', 'An error occurred while deleting the user.');
        }
    }

    public function render()
    {
        return view('livewire.dealer.employee.delete');
    }
}
