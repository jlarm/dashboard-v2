<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Course;

use App\Models\Course;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $selectedStatus;

    public function render(): Factory|View
    {
        return view('livewire.central.course.index', [
            'courses' => Course::query()
                ->select(['id', 'name', 'slug', 'questions'])
                ->whereNot('slug', 'patriot-act-ofac')
                ->with(['results' => function ($query): void {
                    $query->where('user_id', auth()->user()->id)
                        ->latest();
                },
                ])
                ->orderBy('id')
                ->paginate(20),
        ]);
    }
}
