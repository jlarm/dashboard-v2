<?php

namespace App\Http\Livewire\Central\AuditStatements\Osha;

use App\Models\OshaViolationStatements;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public OshaViolationStatements $oshaViolationStatements;

    public function render(): View
    {
        return view('livewire.central.audit-statements.osha.index-item');
    }
}
