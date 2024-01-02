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

    public function getUsersQueryProperty()
    {
        return User::query()
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
            ->search('name', $this->search);
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
            $this->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            // Get all users from the database
            $users = $this->usersQuery->get();

            // Generate the CSV content
            $csvContent = "Name,Email,Department,Courses\n";
            foreach ($users as $user) {
                if ($user->total_completed_courses != $user->total_user_courses) {
                    $csvContent .= "{$user->name},{$user->email},{$user->department->name},$user->total_completed_courses of $user->total_user_courses\n";
                }
            }

            $body = 'Attached is an outline of the progress your employees have made regarding completing their compliance training courses. If an employee is not noted, they have completed all courses assigned. If you have further questions regarding this, you can always access your compliance dashboard and review your departments progress as a whole.';

            // Send the email with the CSV attachment
            Mail::send([], [], function ($message) use ($csvContent, $body) {
                $message->to($this->email)
                    ->from('noreply@armp.app', tenant('name'))
                    ->subject('Incomplete Employee Courses Report as of '.date('m/d/Y'))
                    ->text($body)
                    ->attachData($csvContent, 'incomplete-employee-courses-report-'.date('m-d-Y').'.csv', [
                        'mime' => 'text/csv',
                    ]);
            });

            // Reset the email field
            $this->email = '';

            Notification::make()
                ->title('User Report Sent Successfully')
                ->success()
                ->send();

        } catch (\Exception $e) {
            \Sentry::captureException($e);

            Notification::make()
                ->title('Error trying to send the User Report')
                ->body('Please check the employees email address.')
                ->danger()
                ->send();
        }
    }

    public function render()
    {
        $users = $this->usersQuery->paginate(25);

        if ($this->showIncompleteCourseUsers) {
            $users = $this->usersQuery
                ->when($this->selectedDepartment, function ($query) {
                    $query->where('department_id', $this->selectedDepartment);
                })
                ->paginate(500)
                ->filter(function ($user) {
                    return $user->user_has_not_completed_courses;
                });
        }

        return view('livewire.dealer.employee.index', [
            'users' => $users,
            'departments' => Department::whereHas('users')->orderBy('name')->get(),
            $this->selectedDepartmentName = Department::where('id', $this->selectedDepartment)->first()->name ?? null,
        ]);
    }
}
