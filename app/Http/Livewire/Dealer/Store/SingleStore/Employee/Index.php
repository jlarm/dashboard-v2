<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\User;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Sentry;

class Index extends Component
{
    use WithPagination;

    public Store $store;
    public string $search = '';
    public ?int $selectedDepartment = null;
    public ?int $selectedRole = null;
    public bool $showIncompleteCourseUsers = false;
    public ?string $email = null;
    public string $sortField = 'name';
    public string $sortDirection = 'asc';
    public User $currentUser;
    public array $selectedUsers = [];
    public bool $selectAll = false;

    protected $listeners = ['toggleUserSelection'];

    public $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'selectedDepartment' => ['except' => null, 'as' => 'd'],
        'selectedRole' => ['except' => null, 'as' => 'r'],
        'showIncompleteCourseUsers' => ['except' => false, 'as' => 'i'],
        'sortField' => ['except' => 'name', 'as' => 'sort'],
        'sortDirection' => ['except' => 'asc', 'as' => 'dir'],
    ];

    public function mount(Store $store): void
    {
        $this->store = $store;
        $this->currentUser = auth()->user();
    }

    public function getUsersQueryProperty(): BelongsToMany
    {
        $query = $this->store->users()
            ->select(['id', 'name', 'slug', 'email', 'department_id'])
            ->with([
                'roles',
                'department:id,name',
                'stores:id,name,state',
                'courses:id',
                'courseOverrides:user_id,course_id,type',
                'results' => function ($query) {
                    $query->select('id', 'user_id', 'course_id', 'passed', 'created_at')
                        ->where('passed', 1);
                },
            ])
            ->whereDoesntHave('roles', function ($query): void {
                $query->where('name', 'super-admin')
                    ->orWhere('name', 'Consultant');
            })
            ->currentUserIsManager($this->currentUser);

        // Apply filters
        $this->applyDepartmentFilter($query);
        $this->applyRoleFilter($query);
        $this->applySearchFilter($query);
        $this->applySorting($query);
        $this->applyManagerDepartmentFilter($query);

        return $query;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
        $this->clearSelections();
    }

    public function resetShowIncompleteCourseUsers(): void
    {
        $this->reset(['showIncompleteCourseUsers']);
    }

    public function updatingShowIncompleteCourseUsers(): void
    {
        $this->resetPage();
        $this->clearSelections();
    }

    public function resetSelectedDepartment(): void
    {
        $this->selectedDepartment = null;
    }

    public function updatingSelectedDepartment(): void
    {
        $this->resetPage();
        $this->clearSelections();
    }

    public function updatingSelectedRole(): void
    {
        $this->resetPage();
        $this->clearSelections();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'showIncompleteCourseUsers', 'selectedDepartment', 'selectedRole']);
        $this->resetPage();
        $this->clearSelections();
    }

    public function resetSelectedRole(): void
    {
        $this->selectedRole = null;
        $this->resetPage();
    }

    public function clearSelections(): void
    {
        $this->selectedUsers = [];
        $this->selectAll = false;
    }

    public function toggleSelectAll(): void
    {
        // Toggle the selectAll state first
        $this->selectAll = !$this->selectAll;

        $query = $this->usersQuery;
        $users = $this->showIncompleteCourseUsers
            ? $query->get()->filter(fn ($user) => $user->user_has_not_completed_courses)
            : $query->get();

        if ($this->selectAll) {
            // Select all users
            $this->selectedUsers = $users->pluck('id')->toArray();
        } else {
            // Deselect all users
            $this->selectedUsers = [];
        }
    }

    public function toggleUserSelection(int $userId): void
    {
        if (in_array($userId, $this->selectedUsers, true)) {
            // Remove from array
            $this->selectedUsers = array_values(array_filter($this->selectedUsers, fn($id) => $id !== $userId));
        } else {
            // Add to array
            $this->selectedUsers[] = $userId;
        }

        // Update selectAll state
        $query = $this->usersQuery;
        $users = $this->showIncompleteCourseUsers
            ? $query->get()->filter(fn ($user) => $user->user_has_not_completed_courses)
            : $query->get();

        $this->selectAll = count($this->selectedUsers) === $users->count() && $users->count() > 0;
    }

    public function updatedSelectedUsers(): void
    {
        $query = $this->usersQuery;
        $users = $this->showIncompleteCourseUsers
            ? $query->get()->filter(fn ($user) => $user->user_has_not_completed_courses)
            : $query->get();

        $this->selectAll = count($this->selectedUsers) === $users->count() && $users->count() > 0;
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function exportCsv()
    {
        if (empty($this->selectedUsers)) {
            Notification::make()
                ->title('No Users Selected')
                ->body('Please select at least one user to export.')
                ->warning()
                ->send();

            return;
        }

        // Get all users from current query
        $query = $this->usersQuery;
        $users = $this->showIncompleteCourseUsers
            ? $query->get()->filter(fn ($user) => $user->user_has_not_completed_courses)
            : $query->get();

        // Filter to only selected users
        $selectedUsers = $users->filter(fn ($user) => in_array($user->id, $this->selectedUsers));

        $csvContent = $this->generateExportCsvContent($selectedUsers);
        $filename = 'employee-courses-report-'.date('m-d-Y').'.csv';

        return response()->streamDownload(function () use ($csvContent): void {
            echo $csvContent;
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
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

        } catch (Exception $e) {
            Sentry::captureException($e);

            Notification::make()
                ->title('Error trying to send the User Report')
                ->body('Please check the employees email address.')
                ->danger()
                ->send();
        }
    }

    public function render(): View
    {
        $query = $this->usersQuery;

        $users = $this->showIncompleteCourseUsers
            ? $query->paginate(500)->filter(fn ($user) => $user->user_has_not_completed_courses)
            : $query->paginate(25);

        return view('livewire.dealer.store.single-store.employee.index', [
            'users' => $users,
            'departments' => Department::whereHas('users')->orderBy('name')->get(),
            'roles' => \Spatie\Permission\Models\Role::whereNotIn('name', ['super-admin', 'Consultant'])
                ->whereHas('users')
                ->orderBy('name')
                ->get(),
            'selectedDepartmentName' => $this->selectedDepartmentName,
            'selectedRoleName' => $this->selectedRoleName,
        ])->layout('components.dealer-app');
    }

    public function getSelectedDepartmentNameProperty(): ?string
    {
        if ($this->selectedDepartment === null || $this->selectedDepartment === 0) {
            return null;
        }

        return Department::find($this->selectedDepartment)?->name;
    }

    public function getSelectedRoleNameProperty(): ?string
    {
        if ($this->selectedRole === null || $this->selectedRole === 0) {
            return null;
        }

        return \Spatie\Permission\Models\Role::find($this->selectedRole)?->name;
    }

    private function applyDepartmentFilter(BelongsToMany $query): void
    {
        if ($this->selectedDepartment !== null && $this->selectedDepartment !== 0) {
            $query->where('department_id', $this->selectedDepartment);
        }
    }

    private function applyRoleFilter(BelongsToMany $query): void
    {
        if ($this->selectedRole !== null && $this->selectedRole !== 0) {
            $query->whereHas('roles', function ($query): void {
                $query->where('roles.id', $this->selectedRole);
            });
        }
    }

    private function applySearchFilter(BelongsToMany $query): void
    {
        if ($this->search !== '' && $this->search !== '0') {
            $query->where(function ($query): void {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });
        }
    }

    private function applySorting(BelongsToMany $query): void
    {
        match ($this->sortField) {
            'name' => $query->orderBy('name', $this->sortDirection),
            'department' => $query->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->orderBy('departments.name', $this->sortDirection)
                ->select('users.*'),
            'role' => $query->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->where('model_has_roles.model_type', User::class)
                ->orderBy('roles.name', $this->sortDirection)
                ->select('users.*'),
            default => $query->orderBy('name', 'asc'),
        };
    }

    private function applyManagerDepartmentFilter(BelongsToMany $query): void
    {
        // Restrict managers to their own department unless they have store creation permissions
        if ($this->currentUser->cannot('create-stores') && $this->currentUser->department_id) {
            $query->where('department_id', $this->currentUser->department_id);
        }
    }

    private function generateExportCsvContent(Collection $users): string
    {
        $csvContent = "Name,Store,Department,Completed Courses\n";
        foreach ($users as $user) {
            $name = $this->escapeCsvField($user->name);
            $stores = $this->escapeCsvField($user->stores->pluck('name')->join(', '));
            $department = $this->escapeCsvField($user->department?->name ?? 'N/A');
            $courses = "{$user->total_completed_courses} of {$user->total_user_courses}";

            $csvContent .= "{$name},{$stores},{$department},{$courses}\n";
        }

        return $csvContent;
    }

    private function generateCsvContent(Collection $users): string
    {
        $csvContent = "Name,Email,Department,Courses\n";
        foreach ($users as $user) {
            if ($user->total_completed_courses !== $user->total_user_courses) {
                $csvContent .= "{$user->name},{$user->email},{$user->department->name},{$user->total_completed_courses} of {$user->total_user_courses}\n";
            }
        }

        return $csvContent;
    }

    private function escapeCsvField(?string $field): string
    {
        if ($field === null || $field === '') {
            return '';
        }

        // If field contains comma, quote, or newline, wrap in quotes and escape quotes
        if (str_contains($field, ',') || str_contains($field, '"') || str_contains($field, "\n")) {
            return '"'.str_replace('"', '""', $field).'"';
        }

        return $field;
    }

    private function sendCsvEmail(string $csvContent): void
    {
        $body = 'Attached is an outline of the progress your employees have made regarding completing their compliance training courses. If an employee is not noted, they have completed all courses assigned. If you have further questions regarding this, you can always access your compliance dashboard and review your departments progress as a whole.';
        $filename = 'incomplete-employee-courses-report-'.date('m-d-Y').'.csv';

        Mail::send([], [], function ($message) use ($csvContent, $body, $filename): void {
            $message->to($this->email)
                ->from('noreply@armp.app', tenant('name'))
                ->subject('Incomplete Employee Courses Report as of '.date('m/d/Y'))
                ->text($body)
                ->attachData($csvContent, $filename, [
                    'mime' => 'text/csv',
                ]);
        });

        $this->email = null;
    }
}
