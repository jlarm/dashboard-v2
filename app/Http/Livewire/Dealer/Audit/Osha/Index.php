<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = [
        'refreshAudits' => '$refresh',
    ];
    public function render()
    {
        return view('livewire.dealer.audit.osha.index', [
            'audits' => OshaAudit::latest()->select('id', 'draft', 'created_at')->get()
        ]);
    }
}
