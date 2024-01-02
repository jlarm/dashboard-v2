<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Audit\OshaAudit;
use Livewire\Component;

class GroupRating extends Component
{
    public $rating;

    public $grades = [];

    private function calculateGrade(array $grades): ?string
    {
        if (count($grades) === 0) {
            return null;
        }

        $grade = round(array_sum($grades) / count($grades));

        if ($grade >= 90) {
            return 'A';
        } elseif ($grade >= 80) {
            return 'B';
        } elseif ($grade >= 70) {
            return 'C';
        } elseif ($grade >= 60) {
            return 'D';
        } else {
            return 'F';
        }
    }

    public function getOshaRatingProperty(): ?string
    {
        return $this->calculateGrade(OshaAudit::where('rating', '!=', null)->pluck('rating')->toArray());
    }

    public function getDealJacketRatingProperty(): ?string
    {
        return $this->calculateGrade(IndividualAudit::where('rating', '!=', null)->pluck('rating')->toArray());
    }

    public function getGlbaRatingProperty(): ?string
    {
        return $this->calculateGrade(FinanceAudit::where('rating', '!=', null)->pluck('rating')->toArray());
    }

    public function getBodyShopRatingProperty(): ?string
    {
        return $this->calculateGrade(BodyShopAudit::where('rating', '!=', null)->pluck('rating')->toArray());
    }

    public function mount()
    {
        $this->grades = array_merge(
            $deals = IndividualAudit::where('rating', '!=', null)->pluck('rating')->toArray(),
            $glba = FinanceAudit::where('rating', '!=', null)->pluck('rating')->toArray(),
            $osha = OshaAudit::where('rating', '!=', null)->pluck('rating')->toArray(),
            $body = BodyShopAudit::where('rating', '!=', null)->pluck('rating')->toArray(),
        );

        $this->rating = $this->calculateGrade($this->grades);
    }

    public function getGradeLetterProperty(): string
    {
        return $this->calculateGrade([$this->rating]);
    }

    public function render()
    {
        return view('livewire.dealer.home.group-rating');
    }
}
