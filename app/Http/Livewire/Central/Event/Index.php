<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Event;

use App\Models\Event;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class Index extends Component
{
    /** @var array<string, string> */
    #[Override]
    protected $listeners = [
        'eventAdded' => '$refresh',
    ];

    public function render(): View
    {
        return view('livewire.central.event.index', [
            'events' => Event::query()->where('end_date', '>=', now())
                ->oldest('start_date')
                ->get(),
        ]);
    }
}
