<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class DealJacketStats extends Component
{
    public Store $store;

    public function mount(): void
    {
        $this->store = $this->store ?? Store::first();
    }

    public function rating(): string
    {
        $avg = $this->getAveragePercentage();

        if ($avg === null) {
            return 'N/A';
        }

        return match (true) {
            $avg >= 90 && $avg <= 100 => 'A',
            $avg >= 80 && $avg <= 89 => 'B',
            $avg >= 70 && $avg <= 79 => 'C',
            $avg >= 60 && $avg <= 69 => 'D',
            default => 'F',
        };
    }

    public function render(): View
    {
        return view('livewire.dealer.home.deal-jacket-stats');
    }

    private function getAveragePercentage(): ?float
    {
        $avg = DealJacket::query()
            ->whereHas('dealJacketGroup', function ($query) {
                $query->where('store_id', $this->store->id)
                    ->where('completed', true);
            })
            ->avg('percentage');

        return $avg !== null ? (float) $avg : null;
    }
}
