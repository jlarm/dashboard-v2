<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Course;
use App\Models\Department;
use App\Models\User;
use App\Services\TrainingComplianceService;
use Closure;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Override;
use Sentry;
use Spatie\Permission\Models\Role;

/**
 * @property-read Builder $usersQuery
 * @property-read Collection $departments
 * @property-read Collection $roles
 * @property-read string|null $selectedDepartmentName
 * @property-read string|null $selectedRoleName
 */
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public int|string|null $selectedDepartment = null;
    public int|string|null $selectedRole = null;
    public bool $showIncompleteCourseUsers = false;
    public bool $showExpiredCourseUsers = false;
    public bool $showExpiringSoonCourseUsers = false;
    public ?string $email = null;
    public string $sortField = 'name';
    public string $sortDirection = 'asc';
    public User $currentUser;
    public array $selectedUsers = [];
    public bool $selectAll = false;

    #[Override]
    protected $listeners = ['toggleUserSelection'];

    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'selectedDepartment' => ['except' => null, 'as' => 'd'],
        'selectedRole' => ['except' => null, 'as' => 'r'],
        'showIncompleteCourseUsers' => ['except' => false, 'as' => 'i'],
        'showExpiredCourseUsers' => ['except' => false, 'as' => 'e'],
        'showExpiringSoonCourseUsers' => ['except' => false, 'as' => 'x'],
        'sortField' => ['except' => 'name', 'as' => 'sort'],
        'sortDirection' => ['except' => 'asc', 'as' => 'dir'],
    ];
    private ?Collection $cachedUsers = null;

    public function mount(): void
    {
        $this->currentUser = auth()->user();
    }

    public function getUsersQueryProperty(): Builder
    {
        $query = $this->initialUsersQuery()
            ->whereDoesntHave('roles', function ($query): void {
                $query->where('name', 'super-admin')
                    ->orWhere('name', 'Consultant');
            })
            ->select(['users.id', 'users.name', 'users.slug', 'users.email', 'users.department_id'])
            ->with([
                'roles:id,name',
                'department:id,name',
                'stores:id,name,state',
                'courseOverrides:user_id,course_id,type',
            ]);

        $this->applyDepartmentFilter($query);
        $this->applyRoleFilter($query);
        $this->applySearchFilter($query);
        $this->applySorting($query);
        $this->applyStoreFilter($query);

        return $query;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
        $this->clearSelections();
    }

    public function updatingShowIncompleteCourseUsers(): void
    {
        $this->resetPage();
        $this->clearSelections();
    }

    public function updatingShowExpiredCourseUsers(): void
    {
        $this->resetPage();
        $this->clearSelections();
    }

    public function updatingShowExpiringSoonCourseUsers(): void
    {
        $this->resetPage();
        $this->clearSelections();
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

    public function updatedSelectedDepartment(string $value): void
    {
        $this->selectedDepartment = $value === '' ? null : (int) $value;
    }

    public function updatedSelectedRole(string $value): void
    {
        $this->selectedRole = $value === '' ? null : (int) $value;
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'showIncompleteCourseUsers',
            'showExpiredCourseUsers',
            'showExpiringSoonCourseUsers',
            'selectedDepartment',
            'selectedRole',
        ]);
        $this->resetPage();
        $this->clearSelections();
    }

    public function clearSelections(): void
    {
        $this->selectedUsers = [];
        $this->selectAll = false;
        $this->cachedUsers = null;
    }

    public function toggleUserSelection(int $userId): void
    {
        if (in_array($userId, $this->selectedUsers, true)) {
            $this->selectedUsers = array_values(array_filter($this->selectedUsers, fn ($id): bool => $id !== $userId));
        } else {
            $this->selectedUsers[] = $userId;
        }

        $users = $this->getCachedUsers();
        $this->selectAll = count($this->selectedUsers) === $users->count() && $users->count() > 0;
    }

    public function resetShowIncompleteCourseUsers(): void
    {
        $this->showIncompleteCourseUsers = false;
        $this->resetPage();
    }

    public function resetShowExpiredCourseUsers(): void
    {
        $this->showExpiredCourseUsers = false;
        $this->resetPage();
    }

    public function resetShowExpiringSoonCourseUsers(): void
    {
        $this->showExpiringSoonCourseUsers = false;
        $this->resetPage();
    }

    public function resetSelectedDepartment(): void
    {
        $this->selectedDepartment = null;
        $this->resetPage();
    }

    public function resetSelectedRole(): void
    {
        $this->selectedRole = null;
        $this->resetPage();
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

    public function toggleSelectAll(): void
    {
        $this->selectAll = ! $this->selectAll;

        $users = $this->getCachedUsers();

        $this->selectedUsers = $this->selectAll ? $users->pluck('id')->toArray() : [];
    }

    public function updatedSelectedUsers(): void
    {
        $users = $this->getCachedUsers();
        $this->selectAll = count($this->selectedUsers) === $users->count() && $users->count() > 0;
    }

    public function openCustomMessageModal(): void
    {
        abort_if(auth()->user()?->hasAnyRole(['Manager', 'Employee', 'Porter/Driver']) ?? true, 403);

        $this->dispatch('modal.open', 'dealer.employee.custom-message-modal', [
            'userIds' => $this->selectedUsers,
        ]);
    }

    public function exportCsv(): mixed
    {
        if ($this->selectedUsers === []) {
            Notification::make()
                ->title('No Users Selected')
                ->body('Please select at least one user to export.')
                ->warning()
                ->send();

            return null;
        }

        $users = $this->getCachedUsers();

        $selectedUsers = $users->filter(fn ($user): bool => in_array($user->id, $this->selectedUsers));

        $csvContent = $this->generateExportCsvContent($selectedUsers);
        $contextName = app()->bound('currentStoreModel')
            ? resolve('currentStoreModel')->name
            : tenant('name');
        $slug = str($contextName)->slug()->value();
        $filename = "incomplete-employee-courses-report-{$slug}-".date('m-d-Y').'.csv';

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

    public function getSelectedDepartmentNameProperty(): ?string
    {
        if ($this->selectedDepartment === null || $this->selectedDepartment === 0) {
            return null;
        }

        return Department::query()->find($this->selectedDepartment)?->name;
    }

    public function getSelectedRoleNameProperty(): ?string
    {
        if ($this->selectedRole === null || $this->selectedRole === 0) {
            return null;
        }

        return Role::query()->find($this->selectedRole)?->name;
    }

    public function getDepartmentsProperty(): Collection
    {
        return Department::query()
            ->whereHas('users')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function getRolesProperty(): Collection
    {
        return Role::query()
            ->whereNotIn('name', ['super-admin', 'Consultant'])
            ->whereHas('users')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function render(): View
    {
        $query = $this->usersQuery;
        $scopedUsers = (clone $query)->without(['department'])->get();
        $scopedTrainingSummaries = $this->resolveTrainingSummaries($scopedUsers);
        $trainingCounts = $this->summarizeTrainingCounts($scopedTrainingSummaries);
        $showComplianceFilters = $this->showIncompleteCourseUsers || $this->showExpiredCourseUsers || $this->showExpiringSoonCourseUsers;
        $perPage = $showComplianceFilters ? 500 : 15;
        $paginatedUsers = (clone $query)
            ->with(['results' => $this->constrainResultsQuery(...)])
            ->paginate($perPage);
        $paginatedCollection = collect($paginatedUsers->items());
        $trainingSummaries = $scopedTrainingSummaries->only($paginatedCollection->pluck('id')->all());

        $users = $showComplianceFilters
            ? $paginatedCollection
                ->filter(fn ($user): bool => $user instanceof User && $this->passesComplianceFilters($trainingSummaries->get($user->id)))
                ->values()
            : $paginatedUsers;

        return view('livewire.dealer.employee.index', [
            'users' => $users,
            'departments' => $this->departments,
            'roles' => $this->roles,
            'selectedDepartmentName' => $this->selectedDepartmentName,
            'selectedRoleName' => $this->selectedRoleName,
            'trainingSummaries' => $trainingSummaries,
            'trainingCounts' => $trainingCounts,
        ]);
    }

    private function getCachedUsers(): Collection
    {
        if (! $this->cachedUsers instanceof Collection) {
            $users = $this->usersQuery->get();
            $trainingSummaries = $this->resolveTrainingSummaries($users);

            $this->cachedUsers = ($this->showIncompleteCourseUsers || $this->showExpiredCourseUsers || $this->showExpiringSoonCourseUsers)
                ? $users->filter(fn ($user): bool => $user instanceof User && $this->passesComplianceFilters($trainingSummaries->get($user->id)))->values()
                : $users;
        }

        return $this->cachedUsers;
    }

    private function applyDepartmentFilter(Builder $query): void
    {
        if ($this->selectedDepartment !== null && $this->selectedDepartment !== 0) {
            $query->where('department_id', $this->selectedDepartment);
        }
    }

    private function applyRoleFilter(Builder $query): void
    {
        if ($this->selectedRole !== null && $this->selectedRole !== 0) {
            $query->whereHas('roles', function ($query): void {
                $query->where('roles.id', $this->selectedRole);
            });
        }
    }

    private function applySearchFilter(Builder $query): void
    {
        if ($this->search !== '' && $this->search !== '0') {
            $query->where(function ($query): void {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });
        }
    }

    private function applyStoreFilter(Builder $query): void
    {
        if (! resolve('multipleStoresExist')) {
            return;
        }

        $storeIds = $this->resolveScopedStoreIds();

        if ($storeIds->isEmpty()) {
            $query->whereRaw('1 = 0');

            return;
        }

        $query->whereHas('stores', function ($query) use ($storeIds): void {
            $query->whereIn('stores.id', $storeIds);
        });
    }

    private function resolveScopedStoreIds(): Collection
    {
        /** @var Collection $storeIds */
        $storeIds = resolve('scopedStoreIds');

        return $storeIds;
    }

    private function applySorting(Builder $query): void
    {
        match ($this->sortField) {
            'name' => $query->orderBy('users.name', $this->sortDirection),
            'department' => $query->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->orderBy('departments.name', $this->sortDirection)
                ->select(['users.id', 'users.name', 'users.slug', 'users.email', 'users.department_id']),
            'role' => $query->leftJoin('model_has_roles', function ($join): void {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.model_type', User::class);
            })
                ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->orderBy('roles.name', $this->sortDirection)
                ->select(['users.id', 'users.name', 'users.slug', 'users.email', 'users.department_id']),
            default => $query->orderBy('users.name', 'asc'),
        };
    }

    private function generateExportCsvContent(Collection $users): string
    {
        $trainingSummaries = $this->resolveTrainingSummaries($users);
        $csvContent = "Name,Email,Store,Department,Training Status,Valid Completed,Required Courses,Not Completed,Expired,Expiring Soon\n";

        foreach ($users as $user) {
            $summary = $trainingSummaries->get($user->id);
            $status = is_array($summary) ? $this->trainingStatusLabel($summary['status']) : 'Unknown';
            $validCompleted = is_array($summary) ? (string) $summary['valid_completed'] : '0';
            $requiredCourses = is_array($summary) ? (string) $summary['total_required'] : (string) $user->total_user_courses;
            $notCompleted = is_array($summary) ? (string) $summary['not_completed'] : '0';
            $expired = is_array($summary) ? (string) $summary['expired'] : '0';
            $expiringSoon = is_array($summary) ? (string) $summary['expiring_soon'] : '0';

            $name = $this->escapeCsvField($user->name);
            $email = $this->escapeCsvField($user->email);
            $stores = $this->escapeCsvField($user->stores->pluck('name')->join(', '));
            $department = $this->escapeCsvField($user->department?->name ?? 'N/A');
            $status = $this->escapeCsvField($status);

            $csvContent .= "{$name},{$email},{$stores},{$department},{$status},{$validCompleted},{$requiredCourses},{$notCompleted},{$expired},{$expiringSoon}\n";
        }

        return $csvContent;
    }

    private function generateCsvContent(Collection $users): string
    {
        $trainingSummaries = $this->resolveTrainingSummaries($users);
        $csvContent = "Name,Email,Department,Training Status,Valid Completed,Required Courses,Not Completed,Expired,Expiring Soon\n";

        foreach ($users as $user) {
            $summary = $trainingSummaries->get($user->id);
            $shouldInclude = is_array($summary)
                ? $summary['not_completed'] > 0 || $summary['expired'] > 0 || $summary['expiring_soon'] > 0
                : $user->total_completed_courses !== $user->total_user_courses;

            if (! $shouldInclude) {
                continue;
            }

            $status = is_array($summary) ? $this->trainingStatusLabel($summary['status']) : 'Unknown';
            $validCompleted = is_array($summary) ? (string) $summary['valid_completed'] : '0';
            $requiredCourses = is_array($summary) ? (string) $summary['total_required'] : (string) $user->total_user_courses;
            $notCompleted = is_array($summary) ? (string) $summary['not_completed'] : '0';
            $expired = is_array($summary) ? (string) $summary['expired'] : '0';
            $expiringSoon = is_array($summary) ? (string) $summary['expiring_soon'] : '0';

            $name = $this->escapeCsvField($user->name);
            $email = $this->escapeCsvField($user->email);
            $department = $this->escapeCsvField($user->department?->name ?? 'N/A');
            $status = $this->escapeCsvField($status);

            $csvContent .= "{$name},{$email},{$department},{$status},{$validCompleted},{$requiredCourses},{$notCompleted},{$expired},{$expiringSoon}\n";
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
                ->from((string) config('mail.from.address'), (string) config('mail.from.name'))
                ->subject('Incomplete Employee Courses Report as of '.date('m/d/Y'))
                ->text($body)
                ->attachData($csvContent, $filename, [
                    'mime' => 'text/csv',
                ]);
        });

        $this->email = null;
    }

    private function constrainResultsQuery(HasMany $query): void
    {
        $courseIdsByExpiryYears = Course::query()
            ->select(['id', 'years_expires'])
            ->get()
            ->groupBy(fn (Course $course): int => (int) ($course->years_expires ?? 1))
            ->map(fn (Collection $courses): array => $courses->pluck('id')->all())
            ->all();

        $query->select('id', 'user_id', 'course_id', 'passed', 'created_at')
            ->where('passed', 1)
            ->where(function ($query) use ($courseIdsByExpiryYears): void {
                $hasCourseWindow = false;

                foreach ($courseIdsByExpiryYears as $yearsExpires => $courseIds) {
                    if ($courseIds === []) {
                        continue;
                    }

                    $windowStartsAt = now()->subYears((int) $yearsExpires);

                    if (! $hasCourseWindow) {
                        $query->where(function ($query) use ($courseIds, $windowStartsAt): void {
                            $query->whereIn('course_id', $courseIds)
                                ->where('created_at', '>=', $windowStartsAt);
                        });
                        $hasCourseWindow = true;

                        continue;
                    }

                    $query->orWhere(function ($query) use ($courseIds, $windowStartsAt): void {
                        $query->whereIn('course_id', $courseIds)
                            ->where('created_at', '>=', $windowStartsAt);
                    });
                }

                if (! $hasCourseWindow) {
                    $query->whereRaw('1 = 0');
                }
            });
    }

    private function initialUsersQuery(): Builder
    {
        $query = User::query();

        if ($this->currentUser->cannot('create-stores') && $this->currentUser->department_id) {
            $query->where('department_id', $this->currentUser->department_id);
        }

        return $query;
    }

    /**
     * @param  Collection<int, mixed>  $users
     * @return Collection<int, array{
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int,
     *     status: 'compliant'|'at_risk'|'overdue'|'unassigned'
     * }>
     */
    private function resolveTrainingSummaries(Collection $users): Collection
    {
        return resolve(TrainingComplianceService::class)->summarizeUsers(
            $users
                ->filter(static fn ($user): bool => $user instanceof User)
                ->values()
        );
    }

    /**
     * @param  array{
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int,
     *     status: 'compliant'|'at_risk'|'overdue'|'unassigned'
     * }|null  $summary
     */
    private function passesComplianceFilters(?array $summary): bool
    {
        if (! is_array($summary)) {
            return ! $this->showIncompleteCourseUsers && ! $this->showExpiredCourseUsers && ! $this->showExpiringSoonCourseUsers;
        }

        if ($this->showIncompleteCourseUsers && $summary['not_completed'] <= 0) {
            return false;
        }

        if ($this->showExpiredCourseUsers && $summary['expired'] <= 0) {
            return false;
        }

        return ! ($this->showExpiringSoonCourseUsers && $summary['expiring_soon'] <= 0);
    }

    private function trainingStatusLabel(string $status): string
    {
        return match ($status) {
            'compliant' => 'Compliant',
            'overdue' => 'Overdue',
            'at_risk' => 'At Risk',
            'unassigned' => 'Unassigned',
            default => 'Unknown',
        };
    }

    /**
     * @param  Collection<int, array{
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int,
     *     status: 'compliant'|'at_risk'|'overdue'|'unassigned'
     * }>  $summaries
     * @return Closure
     */
    private function summarizeTrainingCounts(Collection $summaries)
    {
        return $summaries->reduce(
            function (array $carry, array $summary): array {
                $carry['employees']++;
                $carry[$summary['status']]++;
                $carry['incomplete_courses'] += $summary['not_completed'];
                $carry['expired_courses'] += $summary['expired'];
                $carry['expiring_soon_courses'] += $summary['expiring_soon'];

                return $carry;
            },
            [
                'employees' => 0,
                'compliant' => 0,
                'at_risk' => 0,
                'overdue' => 0,
                'unassigned' => 0,
                'incomplete_courses' => 0,
                'expired_courses' => 0,
                'expiring_soon_courses' => 0,
            ],
        );
    }
}
