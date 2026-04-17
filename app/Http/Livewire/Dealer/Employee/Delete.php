<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $user;

    public function mount(User $user): void
    {
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

            return to_route('dealer.employees.index');
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
            $this->addError('file', 'An error occurred while deleting the user.');
        }

        return null;
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.employee.delete');
    }
}
