<?php

namespace App\Http\Livewire\Dealer\Log;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.dealer.log.index', [
            'logs' => Activity::latest()->paginate(25),
        ])->layout('components.dealer-app');
    }
}
