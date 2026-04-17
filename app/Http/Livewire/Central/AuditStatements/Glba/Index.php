<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\AuditStatements\Glba;

use App\Models\GlbaViolationStatements;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): Factory|View
    {
        return view('livewire.central.audit-statements.glba.index', [
            'violations' => GlbaViolationStatements::query()->orderBy('statement')->paginate(20),
        ]);
    }
}
