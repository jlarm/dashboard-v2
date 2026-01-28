<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\AuditStatements\Glba;

use App\Models\GlbaViolationStatements;
use Livewire\Component;

class PrintView extends Component
{
    public function render()
    {
        return view('livewire.central.audit-statements.glba.print-view', [
            'violations' => GlbaViolationStatements::all(),
        ])->layout('layouts.guest');
    }
}
