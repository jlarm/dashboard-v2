<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\AuditStatements\Osha;

use App\Models\OshaViolationStatements;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Override;

class Index extends Component
{
    use WithPagination;

    #[Override]
    protected $listeners = ['statementDeleted' => '$refresh'];

    public function render(): View
    {
        return view('livewire.central.audit-statements.osha.index', [
            'violations' => OshaViolationStatements::query()
                ->select(['id', 'statement', 'weight'])
                ->orderBy('statement')
                ->paginate(20),
        ]);
    }
}
