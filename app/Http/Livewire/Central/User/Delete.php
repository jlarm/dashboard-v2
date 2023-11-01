<?php

namespace App\Http\Livewire\Central\User;

use App\Models\User;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Delete extends Modal
{
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function delete()
    {
        try {
            $this->user->delete();

            $this->emit('saved');

            $this->close();

            Notification::make()
                ->title('User Deleted Successfully!')
                ->success()
                ->send();
        } catch(\Exception $e) {
            \Log::error($e);
            $this->addError('file', 'An error occurred while deleting the file.');
        }
    }

    public function render()
    {
        return view('livewire.central.user.delete');
    }
}
