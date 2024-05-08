<?php

namespace App\Http\Livewire\Central\Contracts;

use App\Models\Contract;
use Livewire\Component;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class IndexItem extends Component
{
    use InteractsWithConfirmationModal;

    public Contract $contract;

    public function delete($contract): void
    {
        $this->askForConfirmation(
            callback: function () use ($contract) {
                ray($contract);
                $contract->delete();
            },
            prompt: [
                'title' => 'Delete Contract ',
                'message' => 'Are you sure you want to delete this contract?',
                'confirm' => 'Yes, delete',
                'cancel' => 'No, cancel',
            ],
        );
    }
    public function render()
    {
        return view('livewire.central.contracts.index-item');
    }
}
