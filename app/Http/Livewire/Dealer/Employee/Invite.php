<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Mail\InviteMail;
use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Mail;
use Spatie\Permission\Models\Role;
use WireElements\Pro\Components\Modal\Modal;

class Invite extends Modal
{
    public $name;

    public $email;

    public $dealers = [];

    public $department;

    public $role;

    public $currentStore = null;

    public $currentStoreId;

    public function mount(Store $currentStore)
    {
        $this->currentStore = $currentStore;
        $this->currentStoreId = $currentStore->id;
    }

    protected $rules = [
        'name' => ['required', 'max:255'],
        'email' => ['required', 'email', 'unique:users', 'max:255'],
        'dealers' => ['nullable', 'array'],
        'department' => ['nullable', 'integer'],
        'role' => ['required', 'string', 'max:255'],
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
                'roles' => $validated['role'],
                'user_id' => auth()->user()->id,
                'invitation_token' => substr(md5(rand(0, 9).$this->email.time()), 0, 32),
            ]);
        } else {
            $invite = \App\Models\Dealer\Invite::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'stores' => $validated['dealers'],
                'department_id' => $validated['department'],
                'roles' => $validated['role'],
                'user_id' => auth()->user()->id,
                'invitation_token' => substr(md5(rand(0, 9).$this->email.time()), 0, 32),
            ]);
        }

        Mail::to($validated['email'])->send(new InviteMail($invite));

//        $this->reset();

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
            'roles' => Role::select('name')->get(),
        ]);
    }
}
