<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Spatie\Permission\Models\Role;
use WireElements\Pro\Components\Modal\Modal;

class Invite extends Modal
{
    public string $name;
    public string $email;
    public string $department;
    public string $role;
    public array $stores = [];
    protected $rules = [
        'name' => ['required', 'max:255'],
        'email' => ['required', 'email', 'unique:users', 'unique:invites', 'max:255'],
        'stores' => ['nullable', 'array'],
        'department' => ['required', 'integer'],
        'role' => ['required'],
    ];

    public function sendInvite()
    {
        $this->validate();

        $invite = \App\Models\Dealer\Invite::create([
            'name' => $this->name,
            'email' => $this->email,
            'stores' => $this->stores ?? [],
            'department_id' => $this->department,
            'roles' => [$this->role],
            'user_id' => auth()->user()->id,
            'invitation_token' => mb_substr(md5(rand(0, 9).$this->email.time()), 0, 32),
        ]);

        SendQueueEmailJob::dispatch($invite, 'invite');

        $this->close();

        Notification::make()
            ->title('Invite Successfully Sent!')
            ->success()
            ->send();
    }

    public function render()
    {
        $qualifiedIndividualCount = \App\Models\User::role('Qualified Individual')->count();

        $rolesQuery = Role::whereNot('name', 'super-admin')
            ->whereNot('name', 'Admin')
            ->whereNot('name', 'Consultant')
            ->orderBy('name');

        if ($qualifiedIndividualCount >= 2) {
            $rolesQuery->whereNot('name', 'Qualified Individual');
        }

        return view('livewire.dealer.employee.invite', [
            'allStore' => Store::orderBy('name')->get(),
            'departments' => Department::orderBy('name')->get(),
            'allRoles' => $rolesQuery->get(),
        ]);
    }
}
