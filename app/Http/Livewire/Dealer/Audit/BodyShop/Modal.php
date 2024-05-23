<?php

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\BodyShopViolationStatement;
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
                return BodyShopViolationStatement::query()
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
            return BodyShopViolationStatement::find($violationId);
        });

        $selectedKeys = ['id' => '', 'statement' => ''];
        $violation = $this->selectedViolation->only(array_keys($selectedKeys));

        $this->emit('violationSelected', $violation);
        $this->close();
    }

    public function render()
    {
        return view('livewire.dealer.audit.body-shop.modal');
    }
}
