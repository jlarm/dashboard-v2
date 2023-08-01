<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Carbon\Carbon;
use Livewire\Component;

class DealJacketStats extends Component
{
    public Store $store;
    public $dealJackets;
    public $sum;
    public ?float $rating;
    public $audits;
    public $dates;

    public function mount()
    {
        $this->store = $this->store ?? Store::first();

        $this->rating = IndividualAudit::where('store_id', $this->store->id)->pluck('rating')->average();

        $this->audits = IndividualAudit::query()
            ->where('store_id', $this->store->id)
            ->where('audit_date', '>=', Carbon::now()->subYears(2))
            ->where('pdf_path', '!=', null)
            ->where('parent_id', null)
            ->orderBy('audit_date', 'desc')
            ->pluck('rating')
            ->values()
            ->toArray();

        $this->dates = IndividualAudit::query()
            ->where('store_id', $this->store->id)
            ->where('audit_date', '>=', Carbon::now()->subYears(2))
            ->where('pdf_path', '!=', null)
            ->where('parent_id', null)
            ->selectRaw('DATE_FORMAT(audit_date, "%Y-%m-%d") as date')
            ->orderBy('date', 'desc')
            ->groupBy('date')
            ->pluck('date')
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.dealer.home.deal-jacket-stats');
    }
}
