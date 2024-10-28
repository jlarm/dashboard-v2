<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Department;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $store;

    public $selectedDepartment = null;

    public $selectedDepartmentName = null;

    public $showIncompleteCourseUsers = false;

    public $email;

    public $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'selectedDepartment' => ['except' => null, 'as' => 'd'],
        'showIncompleteCourseUsers' => ['except' => false, 'as' => 'i'],
    ];

    public function getUsersQueryProperty()
    {
        return User::query()
            ->orderBy('name')
            ->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])
            ->userStore($this->store ?? null)
            ->select(['id', 'name', 'slug', 'email', 'department_id'])
            ->with('roles', 'department', 'stores', 'courses')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'Consultant');
            })
            ->when($this->selectedDepartment, function ($query) {
                $query->where('department_id', $this->selectedDepartment);
            })
            ->currentUserIsManager(auth()->user())
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%');
            });
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetShowIncompleteCourseUsers()
    {
        $this->reset(['showIncompleteCourseUsers']);
    }

    public function updatingShowIncompleteCourseUsers()
    {
        $this->resetPage();
    }

    public function resetSelectedDepartment()
    {
        $this->selectedDepartment = null;
    }

    public function updatingSelectedDepartment()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['showIncompleteCourseUsers', 'selectedDepartment']);
    }

    public function generateCsv()
    {
        try {
            $this->validateEmail();

            $users = $this->usersQuery->get();
            $csvContent = $this->generateCsvContent($users);

            $this->sendEmailWithCsv($csvContent);

            $this->email = '';
            $this->notifySuccess('User Report Sent Successfully');

        } catch (\Exception $e) {
            \Sentry::captureException($e);
            $this->notifyError('Error trying to send the User Report', 'Please check the employees email address.');
        }
    }

    private function validateEmail()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
        ]);
    }

    private function generateCsvContent($users)
    {
        $csvContent = "Name,Email,Department,Courses\n";
        foreach ($users as $user) {
            if ($user->total_completed_courses != $user->total_user_courses) {
                $csvContent .= "{$user->name},{$user->email},{$user->department->name},$user->total_completed_courses of $user->total_user_courses\n";
            }
        }
        return $csvContent;
    }

    private function sendEmailWithCsv($csvContent)
    {
        $body = 'Attached is an outline of the progress your employees have made regarding completing their compliance training courses. If an employee is not noted, they have completed all courses assigned. If you have further questions regarding this, you can always access your compliance dashboard and review your departments progress as a whole.';

        Mail::send([], [], function ($message) use ($csvContent, $body) {
            $message->to($this->email)
                ->from('noreply@armp.app', tenant('name'))
                ->subject('Incomplete Employee Courses Report as of '.date('m/d/Y'))
                ->text($body)
                ->attachData($csvContent, 'incomplete-employee-courses-report-'.date('m-d-Y').'.csv', [
                    'mime' => 'text/csv',
                ]);
        });
    }

    private function notifySuccess($title)
    {
        Notification::make()
            ->title($title)
            ->success()
            ->send();
    }

    private function notifyError($title, $body)
    {
        Notification::make()
            ->title($title)
            ->body($body)
            ->danger()
            ->send();
    }

    public function render()
    {
        $users = $this->getFilteredUsers();

        return view('livewire.dealer.employee.index', [
            'users' => $users,
            'departments' => $this->getDepartments(),
            $this->selectedDepartmentName = $this->getSelectedDepartmentName(),
        ]);
    }

    private function getFilteredUsers()
    {
        $users = $this->usersQuery->paginate(25);

        if ($this->showIncompleteCourseUsers) {
            $users = $this->usersQuery
                ->when($this->selectedDepartment, fn($query) => $query->where('department_id', $this->selectedDepartment))
                ->paginate(500)
                ->filter(fn($user) => $user->user_has_not_completed_courses);
        }

        return $users;
    }

    private function getDepartments()
    {
        return Department::whereHas('users')->orderBy('name')->get();
    }

    private function getSelectedDepartmentName()
    {
        return Department::where('id', $this->selectedDepartment)->first()->name ?? null;
    }
}
