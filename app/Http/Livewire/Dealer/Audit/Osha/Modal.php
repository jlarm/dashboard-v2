<?php

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\OshaViolationStatements;
use Illuminate\Support\Collection;

class Modal extends \WireElements\Pro\Components\Modal\Modal
{
    public $search = '';

    public $selectedViolation = null;

    public Collection $violations;

    public array $selectedViolations = [];

    public function updatedSearch(): void
    {
        if (strlen($this->search >= 2)) {
            $this->violations = tenancy()->central(function ($tenant) {
                return OshaViolationStatements::query()
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
        $this->selectedViolation = tenancy()->central(function ($tenant) use ($violationId) {
            return OshaViolationStatements::find($violationId);
        });

        $selectedKeys = ['id' => '', 'statement' => ''];
        $violation = $this->selectedViolation->only(array_keys($selectedKeys));

        $this->emit('violationSelected', $violation);
        $this->close();
    }

    public function render()
    {
        return view('livewire.dealer.audit.osha.modal');
    }
}
