<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use Illuminate\Support\Facades\Log;
use App\Models\Dealer\Store;
use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public Store $store;
    public $user;

    public function mount(User $user): void
    {
        $this->store = Store::query()->find(app('currentStore'));
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
        } catch (Exception $e) {
            Log::error($e);
            $this->addError('file', 'An error occurred while deleting the user.');
        }
        return null;
    }

    public function render()
    {
        return view('livewire.dealer.employee.delete');
    }
}
