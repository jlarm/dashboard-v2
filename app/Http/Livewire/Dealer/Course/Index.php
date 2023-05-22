<?php

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public User $user;
    public $departmentCourses;
    public $otherCourses;
    public $courses;

    public $search = '';

    public function mount()
    {
        $this->user = auth()->user();
        $this->courses = Course::with('results')
            ->whereDoesntHave('departments')
            ->orWhereHas('departments', function ($query) {
                $query->where('id', $this->user->department_id);
            })
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.dealer.course.index');
    }
}
