<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Course;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    private const EXCLUDED_ROLES = ['super-admin', 'Admin', 'Consultant', 'Qualified Individual'];

    public string $name = '';
    public string $email = '';
    public ?int $department = null;
    public string $role = '';
    public bool $qi = false;
    public array $courses = [];
    public array $dealers = [];
    public ?Store $store = null;

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

    public function submit(): \Illuminate\Http\RedirectResponse|Redirector
    {
        $validated = $this->validate();
        $roles = [$validated['role']];

        if ($this->qi) {
            $roles[] = 'Qualified Individual';
        }

        $invite = Invite::query()->create([
            'name' => mb_convert_case($this->name, MB_CASE_TITLE, 'UTF-8'),
            'email' => mb_strtolower($this->email),
            'stores' => $this->normalizeStoreIds($validated['dealers'] ?? []),
            'department_id' => $validated['department'],
            'user_id' => auth()->user()->id,
            'roles' => array_values(array_unique($roles)),
            'courses' => $this->courses,
            'invitation_token' => Str::random(32),
        ]);

        SendQueueEmailJob::dispatch($invite);

        session()->flash('flash.type', 'success');
        session()->flash('flash.title', 'Employee Invited');
        session()->flash('flash.message', $this->name.' has been successfully invited.');

        return redirect()->route('dealer.employees.index');
    }

    public function render(): View
    {
        return view('livewire.dealer.employee.create', [
            'departments' => Department::query()->orderBy('name')->get(['id', 'name']),
            'allRoles' => $this->availableRoles(),
            'allCourses' => Course::query()->orderBy('name')->get(['id', 'name']),
            'stores' => Store::query()->orderBy('name')->get(['id', 'name']),
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

        if (tenant('locations') && auth()->user()->can('create-stores')) {
            $rules['dealers'] = ['required', 'array', 'min:1'];
            $rules['dealers.*'] = ['integer', Rule::exists('stores', 'id')];
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
