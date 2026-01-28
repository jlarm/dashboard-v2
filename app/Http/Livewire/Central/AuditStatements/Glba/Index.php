<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\AuditStatements\Glba;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.central.audit-statements.glba.index', [
            'violations' => \App\Models\GlbaViolationStatements::orderBy('statement')->paginate(20),
        ]);
    }
}
