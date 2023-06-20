<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Spatie\Permission\Models\Role;
use WireElements\Pro\Components\Modal\Modal;

class Invite extends Modal
{
    public $name;
    public $email;
    public $dealers = [];
    public $department;
    public $roles = [];
    public $currentStore = null;
    public $currentStoreId;
    public $qiCount;

    public function mount(Store $currentStore): void
    {
        $this->currentStore = $currentStore;
        $this->currentStoreId = $currentStore->id;
        $this->qiCount = Role::find(5)->users()->count();
    }

    protected $rules = [
        'name' => ['required', 'max:255'],
        'email' => ['required', 'email', 'unique:users', 'unique:invites', 'max:255'],
        'dealers' => ['nullable', 'array'],
        'department' => ['nullable', 'integer'],
        'roles' => ['min:1', 'array'],
    ];

    public function sendInvite()
    {
        $validated = $this->validate();

        if (auth()->user()->hasRole('Manager')) {
            $invite = \App\Models\Dealer\Invite::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'stores' => [$this->currentStoreId],
                'department_id' => auth()->user()->department_id,
                'roles' => $validated['roles'],
                'user_id' => auth()->user()->id,
                'invitation_token' => substr(md5(rand(0, 9).$this->email.time()), 0, 32),
            ]);
        } else {
            $invite = \App\Models\Dealer\Invite::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'stores' => $validated['dealers'],
                'department_id' => $validated['department'],
                'roles' => $validated['roles'],
                'user_id' => auth()->user()->id,
                'invitation_token' => substr(md5(rand(0, 9).$this->email.time()), 0, 32),
            ]);
        }

//        Mail::to($validated['email'])->send(new InviteMail($invite));
        SendQueueEmailJob::dispatch($invite, 'invite');

        $this->close();

        Notification::make()
            ->title('Invite Successfully Sent!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.employee.invite', [
            'stores' => Store::orderBy('name')->get(),
            'departments' => Department::orderBy('name')->get(),
            'allRoles' => Role::whereNot('name', 'super-admin')
                ->whereNot('name', 'Admin')
                ->whereNot('name', 'Consultant')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
