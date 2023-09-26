<?php

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public User $user;
    public $departmentCourses;
    public $courses;

    public function mount()
    {
        $this->user = auth()->user();
        $userRole = $this->user->roles()->pluck('id')->toArray();
        $userRole = array_diff($userRole, [5]);
        $courseWithRole = \DB::table('course_role')->where('role_id', $userRole)->pluck('course_id')->toArray();
        $this->courses = Course::query()
            ->WhereHas('departments', function ($query) {
                $query->where('id', $this->user->department_id);
            })
            ->whereIn('id', $courseWithRole)
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
