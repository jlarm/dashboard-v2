<?php

namespace App\Http\Livewire\Central\AuditStatements\Osha;

use App\Models\OshaViolationStatements;
use Livewire\Component;

class PrintView extends Component
{
    public function render()
    {
        return view('livewire.central.audit-statements.osha.print-view', [
            'violations' => OshaViolationStatements::all(),
        ])->layout('layouts.guest');
    }
}
