<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Store;
use App\Traits\GlbaGenerateRating;
use Carbon\Carbon;
use Livewire\Component;

class GlbaStats extends Component
{
    use GlbaGenerateRating;

    public Store $store;

    public ?int $rating;

    public $audits;

    public $dates;

    public function mount()
    {
        $this->store = $this->store ?? Store::first();

        $this->rating = FinanceAudit::where('store_id', $this->store->id)->pluck('rating')->average();

        $this->audits = FinanceAudit::query()
            ->where('store_id', $this->store->id)
            ->where('audit_date', '>=', Carbon::now()->subYears(2))
            ->where('pdf_path', '!=', null)
            ->orderBy('audit_date', 'desc')
            ->pluck('rating')
            ->values()
            ->toArray();

        $this->dates = FinanceAudit::query()
            ->where('store_id', $this->store->id)
            ->where('audit_date', '>=', Carbon::now()->subYears(2))
            ->where('pdf_path', '!=', null)
            ->selectRaw('DATE_FORMAT(audit_date, "%Y-%m-%d") as date')
            ->orderBy('date', 'desc')
            ->groupBy('date')
            ->pluck('date')
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.dealer.home.glba-stats');
    }
}
