<?php

declare(strict_types=1);

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
            'logs' => Activity::query()->latest()->paginate(25),
        ]);
    }
}
