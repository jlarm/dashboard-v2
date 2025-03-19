<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Department;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
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

    public User $currentUser;

    public function mount()
    {
        $this->currentUser = auth()->user();
    }

    public $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'selectedDepartment' => ['except' => null, 'as' => 'd'],
        'showIncompleteCourseUsers' => ['except' => false, 'as' => 'i'],
    ];

    public function getUsersQueryProperty()
    {
        $query = $this->initialUsersQuery()
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'super-admin')
                    ->orWhere('name', 'Consultant');
            })
            ->orderBy('name')
            ->select(['id', 'name', 'slug', 'email', 'department_id'])
            ->with('roles', 'department', 'stores', 'courses');
        
        // Apply filters
        $this->applyDepartmentFilter($query);
        $this->applySearchFilter($query);
        
        // Apply tenant location filter if needed
        if (tenant('locations')) {
            $query->whereHas('stores', function ($query) {
                if (!$this->currentUser->hasRole('super-admin')) {
                    $query->whereIn('stores.id', $this->currentUser->stores->pluck('id'));
                }
            });
        }
        
        return $query;
    }

    private function applyDepartmentFilter($query)
    {
        if ($this->selectedDepartment) {
            $query->where('department_id', $this->selectedDepartment);
        }
        
        return $query;
    }

    private function applySearchFilter($query)
    {
        if ($this->search) {
            $query->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }
        
        return $query;
    }

    // Reset filter methods
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingShowIncompleteCourseUsers(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedDepartment(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'showIncompleteCourseUsers', 'selectedDepartment']);
        $this->resetPage();
    }

    public function generateCsv(): void
    {
        try {
            $this->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $users = $this->usersQuery->get();
            $csvContent = $this->generateCsvContent($users);
            $this->sendCsvEmail($csvContent);
            
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

    private function generateCsvContent($users): string
    {
        $csvContent = "Name,Email,Department,Courses\n";
        foreach ($users as $user) {
            if ($user->total_completed_courses != $user->total_user_courses) {
                $csvContent .= "{$user->name},{$user->email},{$user->department->name},$user->total_completed_courses of $user->total_user_courses\n";
            }
        }
        
        return $csvContent;
    }

    private function sendCsvEmail(string $csvContent): void
    {
        $body = 'Attached is an outline of the progress your employees have made regarding completing their compliance training courses. If an employee is not noted, they have completed all courses assigned. If you have further questions regarding this, you can always access your compliance dashboard and review your departments progress as a whole.';
        $filename = 'incomplete-employee-courses-report-' . date('m-d-Y') . '.csv';
        
        Mail::send([], [], function ($message) use ($csvContent, $body, $filename) {
            $message->to($this->email)
                ->from('noreply@armp.app', tenant('name'))
                ->subject('Incomplete Employee Courses Report as of ' . date('m/d/Y'))
                ->text($body)
                ->attachData($csvContent, $filename, [
                    'mime' => 'text/csv',
                ]);
        });
        
        $this->email = '';
    }

    public function getSelectedDepartmentNameProperty()
    {
        if (!$this->selectedDepartment) {
            return null;
        }
        
        return Department::where('id', $this->selectedDepartment)->first()->name ?? null;
    }

    public function render(): View
    {
        $query = $this->usersQuery;
        
        $users = $this->showIncompleteCourseUsers
            ? $query->paginate(500)->filter(fn($user) => $user->user_has_not_completed_courses)
            : $query->paginate(25);

        return view('livewire.dealer.employee.index', [
            'users' => $users,
            'departments' => Department::whereHas('users')->orderBy('name')->get(),
            'selectedDepartmentName' => $this->selectedDepartmentName,
        ]);
    }

    private function initialUsersQuery()
    {
        if ($this->currentUser->cannot('create-stores')) {
            return User::query()
                ->where('department_id', $this->currentUser->department_id);
        }

        return User::query();
    }
}
