<?php

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public User $user;
    public $departmentCourses;
    public $otherCourses;
    public $courses;

    public $search = '';

    public function mount()
    {
        $this->user = auth()->user();
        $this->courses = Course::with('results')
            ->WhereHas('departments', function ($query) {
                $query->where('id', $this->user->department_id);
            })
            ->WhereHas('roles', function ($query) {
                $query->where('id', $this->user->roles()->where('name', '!=', 'Qualified Individual')->first()->id);
            })
            ->orWhereDoesntHave('departments')
            ->with([
                'results' => function ($query) {
                    $query->where('user_id', $this->user->id)->latest();
                }
                ])
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.dealer.course.index');
    }
}
