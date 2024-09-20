<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Models\Dealer\Course;
use App\Models\Dealer\Department;
use App\Models\User;
use Livewire\Component;

class IndexItem extends Component
{
    public User $user;

    public $completed;

    public $totalCourses;

    public $departmentCourseCount;

    public $unassignedCourseCount;

    public $courseWithRole;

//    public function mount()
//    {
//        $this->user = User::find($this->user->id);
//        $userRole = $this->user->roles()->select('id')->first()->toArray();
//        $this->courseWithRole = \DB::table('course_role')->where('role_id', $userRole)->pluck('course_id')->toArray();
//
//        // Get all passed courses within the last year for this user
//        $this->completed = \DB::table('course_results')
//            ->where('user_id', $this->user->id)
//            ->where('created_at', '>=', now()->subYear())
//            ->latest()
//            ->get()
//            ->groupBy('course_id')
//            ->map(function ($item) {
//                return $item->first();
//            });
//
//        $this->completed = collect($this->completed->where('passed', 1))->count();
//
//        $this->totalCourses = Course::query()
//            ->WhereHas('departments', function ($query) {
//                $query->where('id', $this->user->department_id);
//            })
//            ->whereIn('id', $this->courseWithRole)
//            ->orWhereDoesntHave('departments')
//            ->with([
//                'results' => function ($query) {
//                    $query->where('user_id', $this->user->id)->latest('id');
//                },
//            ])->count();
//
//        if ($this->user->stores[0]->state != 'California') {
//            $this->totalCourses = $this->totalCourses - 1;
//        }
//    }

    public function render()
    {
        return view('livewire.dealer.store.single-store.employee.index-item', [
            'department' => Department::where('id', $this->user->department_id)->first(),
        ]);
    }
}
