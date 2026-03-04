<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Settings;

use App\Jobs\SendCoursesResetNotifications;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\CourseResetService;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class CourseResetManager extends Component
{
    use AuthorizesRequests;
    use InteractsWithConfirmationModal;

    public ?int $storeId = null;
    public ?string $storeName = null;
    public string $mode = 'everyone';
    public string $search = '';
    public array $selectedUserIds = [];
    public bool $selectAllVisible = false;

    public function mount(?Store $store = null): void
    {
        $this->storeId = $store?->id;
        $this->storeName = $store?->name;
    }

    public function setMode(string $mode): void
    {
        if (! in_array($mode, $this->modes(), true)) {
            return;
        }

        $this->mode = $mode;
        $this->resetErrorBag('selectedUserIds');
        $this->syncSelectAllVisible();
    }

    public function updatedSearch(): void
    {
        $this->syncSelectAllVisible();
    }

    public function updatedSelectedUserIds(): void
    {
        $this->selectedUserIds = $this->normalizedSelectedUserIds()->all();

        $this->resetErrorBag('selectedUserIds');
        $this->syncSelectAllVisible();
    }

    public function updatedSelectAllVisible(bool $value): void
    {
        $visibleUserIds = $this->visibleUsers()->pluck('id');
        $selectedUserIds = $this->normalizedSelectedUserIds();

        $this->selectedUserIds = $value
            ? $selectedUserIds->merge($visibleUserIds)->unique()->values()->all()
            : $selectedUserIds->diff($visibleUserIds)->values()->all();
    }

    public function toggleSelectedUser(int $userId): void
    {
        $selectedUserIds = $this->normalizedSelectedUserIds();

        $this->selectedUserIds = $selectedUserIds->contains($userId)
            ? $selectedUserIds->reject(static fn (int $selectedUserId): bool => $selectedUserId === $userId)->values()->all()
            : $selectedUserIds->push($userId)->unique()->values()->all();

        $this->resetErrorBag('selectedUserIds');
        $this->syncSelectAllVisible();
    }

    public function resetCourses(): void
    {
        $this->authorize('reset-courses', CourseResults::class);

        $selectedUserIds = $this->selectedUserIdsForReset();

        if ($this->mode === 'selected-users' && $selectedUserIds->isEmpty()) {
            $this->addError('selectedUserIds', 'Select at least one user to reset.');

            return;
        }

        $this->askForConfirmation(
            callback: function () use ($selectedUserIds): void {
                $affectedUserIds = app(CourseResetService::class)->reset(
                    store: $this->resolvedStore(),
                    selectedUserIds: $selectedUserIds
                );

                $this->logCourseReset($selectedUserIds, $affectedUserIds);

                if ($affectedUserIds->isNotEmpty()) {
                    SendCoursesResetNotifications::dispatch(
                        $affectedUserIds,
                        tenant()->name
                    );
                }

                Notification::make()
                    ->title($this->mode === 'selected-users' ? 'Selected Courses Reset Successfully' : 'Courses Reset Successfully')
                    ->success()
                    ->send();

                if ($this->mode === 'selected-users') {
                    $this->selectedUserIds = [];
                    $this->selectAllVisible = false;
                }
            },
            prompt: [
                'message' => $this->confirmationMessage(),
            ]
        );
    }

    public function render(): View
    {
        return view('livewire.dealer.settings.course-reset-manager', [
            'users' => $this->visibleUsers(),
            'resettableUserCount' => $this->resettableUsersQuery()->count(),
            'selectedUserCount' => count($this->selectedUserIds),
            'isStoreScoped' => $this->isStoreScoped(),
        ]);
    }

    private function confirmationMessage(): string
    {
        if ($this->mode === 'selected-users') {
            return __('Are you sure you want to reset courses for the selected users?');
        }

        return __('Are you sure you want to reset all employee courses?');
    }

    private function resettableUsersQuery(?string $search = null): Builder
    {
        $searchTerm = trim((string) $search);

        return User::query()
            ->withoutSuperAdminsAndConsultants()
            ->with([
                'department:id,name',
                'roles:id,name',
                'stores:id,name,state',
                'courseOverrides:user_id,course_id,type',
                'results:id,user_id,course_id,passed,created_at',
            ])
            ->withCount('results')
            ->select(['id', 'name', 'email', 'department_id'])
            ->when($this->isStoreScoped(), function (Builder $query): void {
                $query->whereHas('stores', function (Builder $storeQuery): void {
                    $storeQuery->where('stores.id', $this->storeId);
                });
            })
            ->when($searchTerm !== '', function (Builder $query) use ($searchTerm): void {
                $like = '%'.$searchTerm.'%';

                $query->where(function (Builder $query) use ($like): void {
                    $query->where('name', 'like', $like)
                        ->orWhere('email', 'like', $like)
                        ->orWhereHas('stores', function (Builder $storeQuery) use ($like): void {
                            $storeQuery->where('name', 'like', $like);
                        });
                });
            })
            ->orderBy('name');
    }

    private function visibleUsers(): Collection
    {
        return $this->resettableUsersQuery($this->search)->get();
    }

    private function normalizedSelectedUserIds(): Collection
    {
        return collect($this->selectedUserIds)
            ->map(static fn ($userId): int => (int) $userId)
            ->filter()
            ->unique()
            ->values();
    }

    private function selectedUserIdsForReset(): Collection
    {
        if ($this->mode === 'selected-users') {
            return $this->normalizedSelectedUserIds();
        }

        return $this->resettableUsersQuery()
            ->pluck('id')
            ->map(static fn ($userId): int => (int) $userId)
            ->filter()
            ->unique()
            ->values();
    }

    private function syncSelectAllVisible(): void
    {
        $visibleUserIds = $this->visibleUsers()
            ->pluck('id')
            ->map(static fn ($userId): int => (int) $userId)
            ->values();

        $this->selectAllVisible = $visibleUserIds->isNotEmpty()
            && $visibleUserIds->diff($this->normalizedSelectedUserIds())->isEmpty();
    }

    private function modes(): array
    {
        return ['everyone', 'selected-users'];
    }

    private function logCourseReset(Collection $selectedUserIds, Collection $affectedUserIds): void
    {
        $user = auth()->user();
        $storeName = $this->storeName;

        $description = $this->mode === 'selected-users'
            ? ($this->isStoreScoped()
                ? "Course results reset for selected users in store: {$storeName}"
                : 'Course results reset for selected users')
            : ($this->isStoreScoped()
                ? "Course results reset for store: {$storeName}"
                : 'All employee course results reset');

        $properties = [
            'store_id' => $this->storeId,
            'store_name' => $storeName,
            'reset_scope' => $this->mode === 'selected-users' ? 'selected-users' : 'everyone',
            'selected_user_count' => $selectedUserIds->count(),
            'affected_user_count' => $affectedUserIds->count(),
            'tenant_id' => tenant()?->id,
        ];

        if ($selectedUserIds->isNotEmpty()) {
            $properties['selected_user_ids'] = $selectedUserIds->all();
        }

        activity()
            ->causedBy($user)
            ->withProperties($properties)
            ->log($description);
    }

    private function isStoreScoped(): bool
    {
        return $this->storeId !== null;
    }

    private function resolvedStore(): ?Store
    {
        if (! $this->isStoreScoped()) {
            return null;
        }

        return Store::query()->find($this->storeId);
    }
}
