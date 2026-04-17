<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Course;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    private const array EXCLUDED_ROLES = ['super-admin', 'Admin', 'Consultant', 'Qualified Individual'];

    public string $name = '';
    public string $email = '';
    public ?int $department = null;
    public string $role = '';
    public bool $qi = false;
    public array $courses = [];
    public array $dealers = [];
    public ?int $primaryStoreId = null;
    public ?Store $store = null;
    private ?Collection $memoizedAvailableStores = null;

    public function mount(?Store $store = null): void
    {
        $this->department = auth()->user()->department_id;
        $routeStore = request()->route('store');

        if ($store instanceof Store) {
            $this->store = $store;
        } elseif ($routeStore instanceof Store) {
            $this->store = $routeStore;
        }

        if ($this->store instanceof Store) {
            $this->dealers = [(string) $this->store->id];
        }

        if (auth()->user()->cannot('create-stores') && $this->role === '') {
            $this->role = 'Employee';
        }
    }

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function updatedDealers(): void
    {
        $normalized = $this->normalizeStoreIds($this->dealers);

        if ($this->primaryStoreId !== null && ! in_array($this->primaryStoreId, $normalized, true)) {
            $this->primaryStoreId = null;
        }
    }

    public function submit(): RedirectResponse|Redirector
    {
        $validated = $this->validate();
        $roles = [$validated['role']];
        $assignedStoreIds = $this->resolveAssignedStoreIds($validated['dealers'] ?? []);

        if ($this->qi) {
            $roles[] = 'Qualified Individual';
        }

        $invite = Invite::query()->create([
            'name' => mb_convert_case($this->name, MB_CASE_TITLE, 'UTF-8'),
            'email' => mb_strtolower($this->email),
            'stores' => $assignedStoreIds,
            'primary_store_id' => count($assignedStoreIds) > 1 ? $this->primaryStoreId : null,
            'department_id' => $validated['department'],
            'user_id' => auth()->id(),
            'roles' => array_values(array_unique($roles)),
            'courses' => $this->courses,
            'invitation_token' => Str::random(32),
        ]);

        dispatch(new SendQueueEmailJob($invite));

        session()->flash('flash.type', 'success');
        session()->flash('flash.title', 'Employee Invited');
        session()->flash('flash.message', $this->name.' has been successfully invited.');

        return to_route('dealer.employees.index');
    }

    public function render(): View
    {
        $availableStores = $this->availableStores();

        return view('livewire.dealer.employee.create', [
            'departments' => Department::query()->orderBy('name')->get(['id', 'name']),
            'allRoles' => $this->availableRoles(),
            'allCourses' => Course::query()->orderBy('name')->get(['id', 'name']),
            'stores' => $availableStores,
        ]);
    }

    protected function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users', 'unique:invites', 'max:255'],
            'department' => ['required', 'integer', Rule::exists('departments', 'id')],
            'role' => [
                'required',
                Rule::exists('roles', 'name')->where(fn ($query) => $query->whereNotIn('name', self::EXCLUDED_ROLES)),
            ],
            'qi' => ['nullable', 'boolean'],
            'courses' => ['nullable', 'array'],
            'courses.*' => ['nullable', 'date'],
        ];

        if ($this->availableStores()->count() > 1) {
            $rules['dealers'] = ['required', 'array', 'min:1'];
            $rules['dealers.*'] = ['integer', Rule::exists('stores', 'id')];

            if (count($this->normalizeStoreIds($this->dealers)) > 1) {
                $rules['primaryStoreId'] = ['required', 'integer', Rule::exists('stores', 'id')];
            }
        }

        return $rules;
    }

    private function normalizeStoreIds(array $stores): array
    {
        return collect($stores)
            ->map(fn ($storeId): int => (int) $storeId)
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function resolveAssignedStoreIds(array $selectedStores): array
    {
        $availableStoreIds = $this->availableStores()
            ->pluck('id')
            ->map(static fn ($id): int => (int) $id)
            ->values();

        if ($availableStoreIds->count() === 1) {
            $singleStoreId = $availableStoreIds->first();

            return $singleStoreId === null ? [] : [(int) $singleStoreId];
        }

        $normalizedSelectedStores = collect($this->normalizeStoreIds($selectedStores));

        return $normalizedSelectedStores
            ->filter(fn (int $storeId): bool => $availableStoreIds->contains($storeId))
            ->values()
            ->all();
    }

    /**
     * @return Collection<int, Store>
     */
    private function availableStores(): Collection
    {
        if ($this->memoizedAvailableStores instanceof Collection) {
            return $this->memoizedAvailableStores;
        }

        $user = auth()->user();

        if (! $user instanceof User) {
            return $this->memoizedAvailableStores = Store::query()->orderBy('name')->get(['id', 'name']);
        }

        if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
            return $this->memoizedAvailableStores = Store::query()->orderBy('name')->get(['id', 'name']);
        }

        return $this->memoizedAvailableStores = $user->stores()->orderBy('stores.name')->get(['stores.id', 'stores.name']);
    }

    /**
     * @return Collection<int, Role>
     */
    private function availableRoles(): Collection
    {
        return Role::query()
            ->whereNotIn('name', self::EXCLUDED_ROLES)
            ->orderBy('name')
            ->get();
    }
}
