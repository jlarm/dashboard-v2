<?php

namespace App\Http\Livewire\Central\Course;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $selectedStatus = null;

    public function render()
    {
        return view('livewire.central.course.index', [
            'courses' => Course::query()
                ->select(['id', 'name', 'slug', 'questions'])
                ->whereNot('slug', 'patriot-act-ofac')
                ->with(['results' => function ($query) {
                        $query->where('user_id', auth()->user()->id)
                            ->latest();
                    },
                ])
                ->orderBy('id')
                ->paginate(20),
        ]);
    }
}
