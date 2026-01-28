<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\GlbaViolationStatements;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class Modal extends \WireElements\Pro\Components\Modal\Modal
{
    public $search = '';
    public $selectedViolation = null;
    public Collection $violations;
    public ?int $auditId = null;
    public ?string $auditType = null;
    public array $selectedViolations = [];

    public function mount(?int $auditId = null, ?string $auditType = null): void
    {
        $this->auditId = $auditId;
        $this->auditType = $auditType;
    }

    public function updatedSearch(): void
    {
        if (mb_strlen($this->search) >= 2) {
            $this->violations = tenancy()->central(function ($tenant) {
                return GlbaViolationStatements::query()
                    ->where(function ($term) {
                        $term->where('statement', 'like', '%'.$this->search.'%')
                            ->orWhere('keywords', 'like', '%'.$this->search.'%');
                    })
                    ->get();
            });
        }
    }

    public function selectViolation($violationId): void
    {
        $this->selectedViolation = tenancy()->central(fn ($tenant) => GlbaViolationStatements::find($violationId));

        $selectedKeys = ['id' => '', 'statement' => ''];
        $violation = $this->selectedViolation->only(array_keys($selectedKeys));

        $this->emit('violationSelected', $violation);
        $this->close();
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.finance.modal');
    }
}
