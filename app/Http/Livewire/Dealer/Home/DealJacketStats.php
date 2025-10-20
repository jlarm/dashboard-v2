<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class DealJacketStats extends Component
{
    public Store $store;
    public $dealJackets;
    public $sum;
    public ?float $rating;
    public $audits;
    public $dates;

    public function mount(): void
    {
        $this->store = $this->store ?? Store::first();

        $individualAuditRating = IndividualAudit::where('store_id', $this->store->id)->avg('rating');

        $dealJacketPercentage = DealJacket::whereHas('dealJacketGroup', function ($query) {
            $query->where('store_id', $this->store->id)
                ->where('completed', true);
        })->avg('percentage');

        $ratings = collect([$individualAuditRating, $dealJacketPercentage])->filter()->values();

        $this->rating = $ratings->isNotEmpty() ? $ratings->avg() : null;
    }

    public function rating(): string
    {
        $avg = $this->rating;

        return match (true) {
            $avg >= 90 && $avg <= 100 => 'A',
            $avg >= 80 && $avg <= 89 => 'B',
            $avg >= 70 && $avg <= 79 => 'C',
            $avg >= 60 && $avg <= 69 => 'D',
            $avg > 0 && $avg <= 59 => 'F',
            default => 'N/A',
        };
    }

    public function render(): View
    {
        return view('livewire.dealer.home.deal-jacket-stats');
    }
}
