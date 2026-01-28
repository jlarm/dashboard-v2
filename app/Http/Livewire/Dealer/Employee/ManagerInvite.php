<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Jobs\SendQueueEmailJob;
use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use WireElements\Pro\Components\Modal\Modal;

class ManagerInvite extends Modal
{
    public $name;
    public $email;
    public $role;
    protected $rules = [
        'name' => ['required', 'max:255'],
        'email' => ['required', 'email', 'unique:users', 'unique:invites', 'max:255'],
        'role' => ['required'],
    ];

    public function create()
    {
        $this->validate();

        $invite = Invite::create([
            'name' => $this->name,
            'email' => $this->email,
            'stores' => [auth()->user()->stores->first()->id ?? Store::first()->id],
            'department_id' => auth()->user()->department_id,
            'roles' => $this->role,
            'user_id' => auth()->user()->id,
            'invitation_token' => mb_substr(md5(rand(0, 9).$this->email.time()), 0, 32),
        ]);

        SendQueueEmailJob::dispatch($invite, 'invite');

        Notification::make()
            ->title('Invite Successfully Sent!')
            ->success()
            ->send();

        $this->close();
    }

    public function render()
    {
        return view('livewire.dealer.employee.manager-invite');
    }
}
