<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Traits\GlbaGenerateRating;
use Carbon\Carbon;
use Livewire\Component;

class GlbaStats extends Component
{
    use GlbaGenerateRating;

    public ?int $rating;
    public $audits;
    public $dates;

    public function mount()
    {
        $this->rating = $this->rating();
        $this->audits = cache()->remember('finance_rating', 60*60*24, function () {
            return FinanceAudit::where('audit_date', '>=', Carbon::now()->subYears(2))
                ->where('pdf_path', '!=', null)
                ->orderBy('audit_date', 'desc')
                ->pluck('rating')
                ->values()
                ->toArray();
        });
        $this->dates = cache()->remember('finance_dates', 60*60*24, function () {
            return FinanceAudit::query()
                ->where('audit_date', '>=', Carbon::now()->subYears(2))
                ->where('pdf_path', '!=', null)
                ->selectRaw('DATE_FORMAT(audit_date, "%Y-%m-%d") as date')
                ->orderBy('date', 'desc')
                ->groupBy('date')
                ->pluck('date')
                ->values()
                ->toArray();
        });
    }

    public function render()
    {
        return view('livewire.dealer.home.glba-stats');
    }
}
