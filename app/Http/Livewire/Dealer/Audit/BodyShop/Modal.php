<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Enums\ViolationStatementCategory;
use App\Models\BodyShopViolationStatement;
use App\Models\ViolationStatement;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class Modal extends \WireElements\Pro\Components\Modal\Modal
{
    public string $search = '';
    public Collection $violations;
    public ?int $auditId = null;
    public ?string $auditType = null;

    public function mount(?int $auditId = null, ?string $auditType = null): void
    {
        $this->auditId = $auditId;
        $this->auditType = $auditType;
        $this->violations = collect();
    }

    public function updatedSearch(): void
    {
        if (mb_strlen($this->search) < 2) {
            $this->violations = collect();

            return;
        }

        $all = Cache::remember(
            'violation_statements.'.ViolationStatementCategory::BodyShop->value,
            now()->addDay(),
            fn () => tenancy()->central(fn ($tenant) => ViolationStatement::query()
                ->whereJsonContains('categories', ViolationStatementCategory::BodyShop->value)
                ->get())
        );

        $search = $this->search;

        $this->violations = $all->filter(fn (ViolationStatement $v): bool => mb_stripos($v->statement, $search) !== false
            || collect($v->keywords)->contains(fn ($k): bool => mb_stripos((string) $k, $search) !== false)
        )->values();
    }

    public function selectViolation(int $violationId): void
    {
        $violation = tenancy()->central(fn ($tenant) => BodyShopViolationStatement::query()->find($violationId));

        $this->emit('violationSelected', $violation->only(['id', 'statement']));
        $this->close();
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.body-shop.modal');
    }
}
