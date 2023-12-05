<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Invite;
use Livewire\Component;
use Livewire\WithPagination;

class OpenInvites extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['refreshOpenInvites' => '$refresh'];

    public function render()
    {
        $query = Invite::query()
            ->where('registered_at', null)
            ->with('user')
            ->with('store')
            ->orderBy('created_at', 'desc')
            ->search('name', $this->search);

        if (auth()->user()->hasRole('Manager')) {
            $query->where('department_id', auth()->user()->department_id);
        }

        return view('livewire.dealer.employee.open-invites', [
            'invites' => $query->paginate(10),
        ]);
    }
}
