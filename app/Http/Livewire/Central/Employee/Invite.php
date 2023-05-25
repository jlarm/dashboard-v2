<?php

namespace App\Http\Livewire\Central\Employee;

use App\Notifications\UserInviteNotification;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use WireElements\Pro\Components\Modal\Modal;

class Invite extends Modal
{
    public $name;

    public $email;

    public $role;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'role' => 'required|string',
    ];

    public function sendInvite()
    {
        $validated = $this->validate();

        $this->email = $validated['email'];
        $this->name = $validated['name'];
        $this->role = $validated['role'];

        Notification::route('mail', $this->email)
            ->notify(new UserInviteNotification($validated));

        $this->close();
    }

    public function render()
    {
        return view('livewire.central.employee.invite', [
            'roles' => Role::where('name', 'Consultant')->orWhere('name', 'Admin')->get()
        ]);
    }
}
