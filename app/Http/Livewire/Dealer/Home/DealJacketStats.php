<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\IndividualAudit;
use Carbon\Carbon;
use Livewire\Component;

class DealJacketStats extends Component
{
    public $dealJackets;
    public $sum;
    public ?float $rating;
    public $audits;
    public $dates;

    public function mount()
    {
        $this->dealJackets = IndividualAudit::where('parent_id', null)
            ->where('pdf_path', '!=', null)
            ->get();
        $this->dealJackets->filter(function ($value) {
            for ($i = 3; $i <= 40; $i++) {
                if ($i != 19 && $value->{'individual_q' . $i .'_answer'} == 2) {
                    $this->sum += 1;
                }
            }

            $total = count($this->dealJackets) * 37;
            $wrong = $this->sum;
            $this->rating = number_format(100 * ($total - $wrong) / $total, 2, '.', '');
        });

        $this->audits = cache()->remember('individual_rating', 60*60*24, function () {
            return IndividualAudit::where('audit_date', '>=', Carbon::now()->subYears(2))
                ->where('pdf_path', '!=', null)
                ->where('parent_id', null)
                ->orderBy('audit_date', 'desc')
                ->pluck('rating')
                ->values()
                ->toArray();
        });
        $this->dates = cache()->remember('individual_dates', 60*60*24, function () {
            return IndividualAudit::query()
                ->where('audit_date', '>=', Carbon::now()->subYears(2))
                ->where('pdf_path', '!=', null)
                ->where('parent_id', null)
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
        return view('livewire.dealer.home.deal-jacket-stats');
    }
}
