<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Course;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class CourseResults extends Component
{
    use WithPagination;

    public Store $store;
    public User $user;

    protected $listeners = ['refreshEmployeeDetails' => '$refresh'];

    public function mount()
    {
        $this->store = $this->user->stores->first() ?? Store::first();
    }

    public function render()
    {
        return view('livewire.dealer.employee.course-results', [
            'courses' => Course::with('results')
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
                },
            ])->orderBy('name')->paginate(24),
        ]);
    }
}
