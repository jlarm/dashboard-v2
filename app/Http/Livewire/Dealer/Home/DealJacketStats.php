<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class DealJacketStats extends Component
{
    public Store $store;

    public function mount(): void
    {
        $this->store ??= app('currentStoreModel') ?? Store::query()->first();
    }

    public function rating(): string
    {
        $avg = $this->getAveragePercentage();

        if ($avg === null) {
            return 'N/A';
        }

        return match (true) {
            $avg >= 90 => 'A',
            $avg >= 80 => 'B',
            $avg >= 70 => 'C',
            $avg >= 60 => 'D',
            default => 'F',
        };
    }

    public function render(): View
    {
        return view('livewire.dealer.home.deal-jacket-stats');
    }

    private function getAveragePercentage(): ?float
    {
        $completedGroups = DealJacketGroup::query()
            ->where('store_id', $this->store->id)
            ->where('completed', true)
            ->withSum('dealJackets as total_passed', 'total_passed')
            ->withSum('dealJackets as total_failed', 'total_failed')
            ->get();

        if ($completedGroups->isEmpty()) {
            return null;
        }

        $totalPassRate = $completedGroups->sum(fn ($group) => $group->pass_rate);

        return $totalPassRate / $completedGroups->count();
    }
}
