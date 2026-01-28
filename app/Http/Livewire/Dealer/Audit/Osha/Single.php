<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaViolationAudit;
use Livewire\Component;

class Single extends Component
{
    public OshaViolationAudit $oshaViolationAudit;
    public $store;
    public $rating;

    public function mount()
    {
        $count = $this->oshaViolationAudit->violations->count();

        $this->rating = match (true) {
            $count === 0 => 99,
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
        return view('livewire.dealer.audit.osha.single', [
            'violations' => $this->oshaViolationAudit->violations,
        ])->layout('components.dealer-app');
    }
}
