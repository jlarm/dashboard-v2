<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Event;

use App\Models\Event;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'eventAdded' => '$refresh',
    ];

    public function render(): View
    {
        return view('livewire.central.event.index', [
            'events' => Event::where('end_date', '>=', now())
                ->orderBy('start_date', 'asc')
                ->get(),
        ]);
    }
}
