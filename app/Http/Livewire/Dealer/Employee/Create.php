<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Course;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use Illuminate\Http\Request;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public string $name;
    public string $email;
    public string $department;
    public string $departmentId;
    public string $role;
    public bool $qi = false;
    public array $roles = [];
    public array $courses = [];
    public array $dealers = [];
    public $currentStore;
    protected $rules = [
        'name' => ['required', 'max:255'],
        'email' => ['required', 'email', 'unique:users', 'unique:invites', 'max:255'],
        //        'department' => ['required', 'integer'],
        'roles' => ['min:1', 'array'],
        'qi' => ['nullable', 'boolean'],
        'courses' => ['nullable', 'array'],
    ];

    public function mount(Request $request): void
    {
        $this->departmentId = auth()->user()->department_id ?? '';
        $this->currentStore = $request->get('store')?->id ?? '';
        $this->dealers[] = $request->get('store')?->id ? (string) $request->get('store')?->id : [];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        if ($this->qi) {
            $this->roles[] = 'Qualified Individual';
        }

        $invite = Invite::query()->create([
            'name' => mb_convert_case($this->name, MB_CASE_TITLE, 'UTF-8'),
            'email' => mb_strtolower($this->email),
            'stores' => $this->dealers,
            'department_id' => $this->department,
            'user_id' => auth()->user()->id,
            'roles' => $this->roles,
            'courses' => $this->courses,
            'invitation_token' => mb_substr(md5(random_int(0, 9).$this->email.time()), 0, 32),
        ]);

        SendQueueEmailJob::dispatch($invite);

        session()->flash('flash.type', 'success');
        session()->flash('flash.title', 'Employee Invited');
        session()->flash('flash.message', $this->name.' has been successfully invited.');

        return redirect()->route('dealer.employees.index');

    }

    public function render()
    {
        $rolesQuery = Role::query()
            ->whereNotIn('name', ['super-admin', 'Admin', 'Consultant', 'Qualified Individual'])
            ->orderBy('name');

        return view('livewire.dealer.employee.create', [
            'departments' => Department::all(),
            'allRoles' => $rolesQuery->get(),
            'allCourses' => Course::query()->select('id', 'name')->get(),
            'stores' => Store::query()->orderBy('name')->get(),
        ]);
    }
}
