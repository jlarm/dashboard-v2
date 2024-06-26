<?php

namespace App\Http\Livewire\Central\Logs;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.central.logs.index', [
            'logs' => Activity::latest()->paginate(25),
        ]);
    }
}
