<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Logs;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Index extends Component
{
    use WithPagination;

    public function render(): Factory|View
    {
        return view('livewire.central.logs.index', [
            'logs' => Activity::query()->latest()->paginate(25),
        ]);
    }
}
