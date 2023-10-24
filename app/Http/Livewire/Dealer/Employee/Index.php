<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $courses;
    public $completed;
    public $totalCourses;
    public $showIncompleteCourses;
    public $selectPage = false;
    public $selectAll = false;
    public $selected = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'showIncompleteCourses' => ['except' => false],
    ];

    public function getUsersQueryProperty()
    {
        return User::query()
            ->with('roles', 'department', 'stores')
            ->orderBy('name')
            ->whereNotIn('name', ['Terry Dortch', 'Mike Backer', 'Joe Lohr'])
            ->search('name', $this->search);
    }

    public function getUsersProperty()
    {
        if ($this->showIncompleteCourses) {
            return $this->usersQuery->get();
        }
        return $this->usersQuery
            ->paginate(10);
    }

    public function isNotCaliforniaStore(): bool
    {
        return Store::exists() && Store::first()->pluck('state') != 'California';
    }

    public function updatedSelected(): void
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function updatedSelectPage($value): void
    {
            $this->selected = $value
                ? $this->users->pluck('id')->map(fn ($id) => (string) $id)
                : [];
    }

    public function selectAll(): void
    {
        $this->selectAll = true;
    }

    public function hideIncompleteCourses()
    {
        $this->showIncompleteCourses = false;
    }


    public function exportCsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return response()->streamDownload(function () {
            echo $this->usersQuery->toCsv();
        }, 'exported-users.csv');
    }

    public function exportSelected(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $selectedUsers = $this->usersQuery
            ->unless($this->selectAll, fn ($query) => $query->whereIn('id', $this->selected))
            ->get()
            ->map(function ($user) {
                return collect($user->toArray())
                    ->put('courses_completed', $user->total_completed_courses . ' of ' . $user->total_user_courses)
                    ->forget(['created_at', 'updated_at', 'deleted_at', 'roles', 'department', 'email_verified_at', 'id', 'department_id', 'slug'])
                    ->all();
            });

        $csvContent = collect($selectedUsers)->toCSV();

        $fileName = 'exported-users.csv';
        return response()->stream(
            function () use ($csvContent) {
                echo $csvContent;
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename={$fileName}",
            ]
        );
    }

    public function render()
    {
        $users = $this->users;

        if ($this->showIncompleteCourses) {
            $users = $this->users->filter(function ($user) {
                return $user->user_has_not_completed_courses;
            });
        }

        if ($this->selectAll) {
            $this->selected = $users->pluck('id')->map(fn ($id) => (string) $id);
        }

        return view('livewire.dealer.employee.index', [
            'users' => $users,
        ]);
    }
}
