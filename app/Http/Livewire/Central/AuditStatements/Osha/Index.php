<?php

namespace App\Http\Livewire\Central\AuditStatements\Osha;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.central.audit-statements.osha.index', [
            'violations' => \App\Models\OshaViolationStatements::orderBy('statement')->paginate(20),
        ]);
    }
}
