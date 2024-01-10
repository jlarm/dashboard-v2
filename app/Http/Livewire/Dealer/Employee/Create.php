<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Course;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use App\Models\User;
use Filament\Notifications\Notification;
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

    public array $roles = [];

    public array $courses = [];

    public array $dealers = [];

    public $currentStore;

    public function mount(Request $request): void
    {
        $this->departmentId = auth()->user()->department_id ?? '';
        $this->currentStore = $request->get('store')?->id ?? '';
        $this->dealers[] = $request->get('store')?->id ? (string) $request->get('store')?->id : [];
    }

    protected $rules = [
        'name' => ['required', 'max:255'],
        'email' => ['required', 'email', 'unique:users', 'unique:invites', 'max:255'],
        //        'department' => ['required', 'integer'],
        'roles' => ['min:1', 'array'],
        'courses' => ['nullable', 'array'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        $invite = Invite::create([
            'name' => $this->name,
            'email' => $this->email,
            'stores' => $this->dealers,
            'department_id' => $this->department,
            'user_id' => auth()->user()->id,
            'roles' => $this->roles,
            'courses' => $this->courses,
            'invitation_token' => substr(md5(rand(0, 9).$this->email.time()), 0, 32),
        ]);

        SendQueueEmailJob::dispatch($invite, 'invite');

        Notification::make()
            ->title('Invite Successfully Sent!')
            ->success()
            ->send();

        return redirect()->route('dealer.employees.index');

    }

    public function render()
    {
        $qualifiedIndividualCount = \App\Models\User::role('Qualified Individual')->count();

        $rolesQuery = Role::query()
            ->whereNot('name', 'super-admin')
            ->whereNot('name', 'Admin')
            ->whereNot('name', 'Consultant')
            ->orderBy('name');

        if ($qualifiedIndividualCount >= 2) {
            $rolesQuery->whereNot('name', 'Qualified Individual');
        }

        return view('livewire.dealer.employee.create', [
            'departments' => Department::all(),
            'allRoles' => $rolesQuery->get(),
            'allCourses' => Course::select('id', 'name')->get(),
            'stores' => Store::orderBy('name')->get(),
        ]);
    }
}
