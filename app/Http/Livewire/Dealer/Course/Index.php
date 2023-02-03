<?php

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        if (auth()->user()->department_id) {
            return view('livewire.dealer.course.index', [
                'courses' => Course::query()
                    ->select('id', 'slug', 'name')
                    ->where('department_id', auth()->user()->department_id)
                    ->with([
                        'results' => function ($query) {
                            $query->where('user_id', auth()->user()->id)->latest()->take(1);
                        },
                    ])
                    ->orderBy('name')
                    ->paginate(12),
            ]);
        } else {
            return view('livewire.dealer.course.index', [
                'courses' => Course::query()
                    ->select('id', 'slug', 'name')
                    ->with([
                        'results' => function ($query) {
                            $query->where('user_id', auth()->user()->id)->latest()->take(1);
                        },
                    ])
                    ->orderBy('name')
                    ->paginate(12),
            ]);
        }
    }
}
