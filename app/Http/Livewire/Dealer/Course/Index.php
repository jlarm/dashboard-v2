<?php

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use App\Models\Dealer\Department;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        if (auth()->user()->department_id) {
            return view('livewire.dealer.course.index', [
                'courses' => Department::where('id', auth()->user()->department_id)->with('courses')->first()->courses()->with([
                    'results' => function ($query) {
                        $query->where('user_id', auth()->user()->id);
                    },
                ])->orderBy('name')->search('name', $this->search)->paginate(24),
            ]);
        } else {
            return view('livewire.dealer.course.index', [
                'courses' => Course::query()
                    ->select('id', 'slug', 'name')
                    ->with([
                        'results' => function ($query) {
                            $query->where('user_id', auth()->user()->id);
                        },
                    ])
                    ->orderBy('name')
                    ->search('name', $this->search)
                    ->paginate(24),
            ]);
        }
    }
}
