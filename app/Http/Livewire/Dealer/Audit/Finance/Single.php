<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\GlbaViolationAudit;
use Livewire\Component;

class Single extends Component
{
    public GlbaViolationAudit $glbaViolationAudit;

    public $store;

    public $rating;

    public function mount()
    {
        $count = $this->glbaViolationAudit->violations->count();

        $this->rating = match (true) {
            $count == 0 => 99,
            $count > 0 && $count <= 10 => 75,
            $count >= 11 && $count <= 20 => 50,
            $count >= 21 && $count <= 30 => 25,
            $count >= 31 && $count <= 40 => 10,
            $count >= 41 && $count <= 50 => 5,
            default => 'N/A',
        };

    }

    public function render()
    {
        return view('livewire.dealer.audit.finance.single', [
            'violations' => $this->glbaViolationAudit->violations,
        ])->layout('components.dealer-app');
    }
}
