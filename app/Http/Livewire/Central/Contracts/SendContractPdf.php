<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Contracts;

use Illuminate\Support\Facades\Notification;
use App\Notifications\ContractPdfNotification;
use App\Models\Contract;
use Livewire\Component;

class SendContractPdf extends Component
{
    public Contract $contract;
    public $sendPdfEmailAddress;

    public function sendContractPdf(): void
    {
        Notification::route('mail', $this->sendPdfEmailAddress)
            ->notify(new ContractPdfNotification($this->contract));

        $this->contract->status()->create([
            'name' => auth()->user()->name,
            'status' => 'sent contract pdf to '.$this->sendPdfEmailAddress,
            'step' => 5,
        ]);

        \Filament\Notifications\Notification::make()
            ->title('Contract PDF Sent')
            ->success()
            ->send();

        $this->reset('sendPdfEmailAddress');

        $this->emit('contractUpdated');
    }

    public function render()
    {
        return view('livewire.central.contracts.send-contract-pdf');
    }
}
