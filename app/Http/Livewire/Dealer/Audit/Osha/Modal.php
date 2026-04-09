<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Enums\ViolationStatementCategory;
use App\Models\ViolationStatement;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class Modal extends \WireElements\Pro\Components\Modal\Modal
{
    public string $search = '';
    public ?ViolationStatement $selectedViolation = null;
    public Collection $violations;
    public ?int $auditId = null;
    public ?string $auditType = null;
    public array $selectedViolations = [];

    public function mount(?int $auditId = null, ?string $auditType = null): void
    {
        $this->auditId = $auditId;
        $this->auditType = $auditType;
        $this->violations = collect();
    }

    public function updatedSearch(): void
    {
        if (mb_strlen((string) $this->search) < 2) {
            $this->violations = collect();

            return;
        }

        $all = Cache::remember(
            'violation_statements.'.ViolationStatementCategory::Osha->value,
            now()->addDay(),
            fn () => tenancy()->central(fn () => ViolationStatement::query()
                ->whereJsonContains('categories', ViolationStatementCategory::Osha->value)
                ->get())
        );

        $search = $this->search;

        $this->violations = $all->filter(fn (ViolationStatement $v): bool => mb_stripos($v->statement, (string) $search) !== false
            || collect($v->keywords)->contains(fn ($k): bool => mb_stripos((string) $k, (string) $search) !== false)
        )->values();
    }

    public function selectViolation(int $violationId): void
    {
        $this->selectedViolation = tenancy()->central(fn () => ViolationStatement::query()->find($violationId));

        $this->emit('violationSelected', $this->selectedViolation->only(['id', 'statement']));
        $this->close();
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.osha.modal');
    }
}
