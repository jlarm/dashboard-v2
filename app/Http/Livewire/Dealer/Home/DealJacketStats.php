<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Cache;
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

        $this->rating = Cache::remember(
            'deal_jacket_rating_'.$this->store->id,
            now()->addHour(),
            fn () => IndividualAudit::where('store_id', $this->store->id)->avg('rating')
        );
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
