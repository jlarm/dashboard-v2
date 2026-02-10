<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\AuditStatements\Glba;

use App\Models\GlbaViolationStatements;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.central.audit-statements.glba.index', [
            'violations' => GlbaViolationStatements::query()->orderBy('statement')->paginate(20),
        ]);
    }
}
