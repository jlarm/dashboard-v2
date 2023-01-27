<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Department;
use App\Models\Dealer\Store;
use App\Notifications\DealerUserInviteNotification;
use App\Notifications\UserInviteNotification;
use Illuminate\Support\Facades\Notification;
use WireElements\Pro\Components\Modal\Modal;

class Invite extends Modal
{
    public $name;
    public $email;
    public $store;
    public $department;
    public $role;


    protected $rules = [
        'name' => ['required', 'max:255'],
        'email' => ['required', 'email', 'unique:users', 'max:255'],
        'store' => ['nullable', 'integer'],
        'department' => ['nullable', 'integer'],
        'role' => ['required', 'string', 'max:255']
    ];

    public function invite()
    {
        $validated = $this->validate();

        $this->email = $validated['email'];
        $this->name = $validated['name'];
        $this->store = $validated['store'];
        $this->department = $validated['department'];
        $this->role = $validated['role'];

        Notification::route('mail', $this->email)
            ->notify(new DealerUserInviteNotification($validated));

        $this->close();
    }
    public function render()
    {
        return view('livewire.dealer.employee.invite', [
            'stores' => Store::all(),
            'departments' => Department::all(),
        ]);
    }
}
