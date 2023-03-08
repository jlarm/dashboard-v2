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

        $invite = \App\Models\Dealer\Invite::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'stores' => $validated['dealers'],
            'department_id' => $validated['department'],
            'roles' => $validated['role'],
            'user_id' => auth()->user()->id,
            'invitation_token' => substr(md5(rand(0, 9).$this->email.time()), 0, 32),
        ]);

        Mail::to($validated['email'])->send(new InviteMail($invite));

        $this->reset();

        $this->close();

        Notification::make()
            ->title('Invite Successfully Sent!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.dealer.employee.invite', [
            'stores' => Store::all(),
            'departments' => Department::all(),
            'roles' => Role::get(),
        ]);
    }
}
