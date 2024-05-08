<?php

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Livewire\Component;
use Notification;

class SendContract extends Component
{
    public Contract $contract;
    public $sendEmailAddress;

    public function sendContract()
    {
        $this->validate([
            'sendEmailAddress' => 'required|email',
        ]);

        Notification::route('mail', $this->sendEmailAddress)
            ->notify(new \App\Notifications\ContractNotification($this->contract));

        $this->contract->update([
            'contract_sent_to' => $this->sendEmailAddress,
        ]);

        $this->contract->status()->create([
            'name' => auth()->user()->name,
            'status' => 'sent contract to ' . $this->sendEmailAddress,
            'step' => 2,
        ]);

        $this->reset('sendEmailAddress');

        \Filament\Notifications\Notification::make()
            ->title('Contract Sent fo Review')
            ->success()
            ->send();

        $this->emit('contractUpdated');
    }

    public function render()
    {
        return view('livewire.central.contracts.send-contract');
    }
}
