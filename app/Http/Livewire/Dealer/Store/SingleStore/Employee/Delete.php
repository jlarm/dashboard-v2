<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Models\Dealer\Store;
use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use Log;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $user;
    public $store;

    public function mount(User $user, Store $store)
    {
        $this->user = $user;
        $this->store = $store;
    }

    public function delete()
    {
        try {
            $this->user->delete();

            $this->close();

            Notification::make()
                ->title('Employee Deleted Successfully!')
                ->success()
                ->send();

            return redirect()->route('dealer.stores.employees', $this->store->slug);
        } catch (Exception $e) {
            Log::error($e);
            $this->addError('file', 'An error occurred while deleting the user.');
        }
    }

    public function render()
    {
        return view('livewire.dealer.store.single-store.employee.delete');
    }
}
