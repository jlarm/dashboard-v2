<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public User $user;
    public bool $videosAreActive;
    public int $videoCount;

    public function render(): View
    {
        return view('livewire.dealer.employee.index-item', [
            'completedVideoCount' => $this->user->videoProgress()->count(),
        ]);
    }
}
