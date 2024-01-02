<?php

namespace App\Http\Livewire\Central\Event;

use App\Models\Event;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'eventAdded' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.central.event.index', [
            'events' => Event::where('end_date', '>=', now())
                ->orderBy('start_date', 'asc')
                ->get(),
        ]);
    }
}
