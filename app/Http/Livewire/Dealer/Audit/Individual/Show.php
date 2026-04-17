<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Override;

class Show extends Component
{
    public IndividualAudit $individualAudit;
    public $audits;
    public $children;
    public $rating;
    protected $sum;

    #[Override]
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount(): void
    {
        $this->audits = collect([$this->individualAudit, ...$this->individualAudit->children]);
    }

    public function getQuarterNameAttribute(): ?string
    {
        $month = (int) $this->individualAudit->audit_date->format('n');

        return match (true) {
            $month <= 3 => 'Q1',
            $month <= 6 => 'Q2',
            $month <= 9 => 'Q3',
            default => 'Q4',
        };
    }

    public function delete()
    {
        $this->individualAudit->delete();

        return to_route('dealer.audit.individual.index');
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.audit.individual.show');
    }
}
