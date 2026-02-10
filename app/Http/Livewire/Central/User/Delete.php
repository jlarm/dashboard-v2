<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\User;

use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $user;

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function delete(): void
    {
        try {
            $this->user->delete();

            $this->emit('saved');

            $this->close();

            Notification::make()
                ->title('User Deleted Successfully!')
                ->success()
                ->send();
        } catch (Exception $e) {
            Log::error($e);
            $this->addError('file', 'An error occurred while deleting the file.');
        }
    }

    public function render()
    {
        return view('livewire.central.user.delete');
    }
}
