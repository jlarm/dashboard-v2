<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use App\Notifications\ContractNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class SendContract extends Component
{
    public Contract $contract;
    public $emailAddresses = [];
    public $emailAddress;

    public function addEmailAddress(): void
    {
        $this->validate([
            'emailAddress' => 'required|email',
        ]);

        if (in_array($this->emailAddress, $this->emailAddresses)) {
            $this->addError('emailAddress', 'The email address already exists in the list.');

            return;
        }

        $this->emailAddresses[] = $this->emailAddress;
        $this->emailAddress = '';
    }

    public function removeEmailAddress($index): void
    {
        unset($this->emailAddresses[$index]);

        $this->emailAddresses = array_values($this->emailAddresses);
    }

    public function sendContract(): void
    {
        if ($this->emailAddresses === []) {
            $this->addError('emailAddresses', 'Please add at least one email address.');

            return;
        }

        foreach ($this->emailAddresses as $email) {
            Notification::route('mail', $email)
                ->notify(new ContractNotification($this->contract));

            $this->contract->status()->create([
                'name' => auth()->user()->name,
                'status' => 'sent contract to '.$email,
                'step' => 2,
            ]);
        }

        $this->reset('emailAddresses');

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
