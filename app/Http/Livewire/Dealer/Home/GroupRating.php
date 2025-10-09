<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class GroupRating extends Component
{
    private const array GRADE_VALUES = [
        'A' => 90,
        'B' => 80,
        'C' => 70,
        'D' => 60,
        'F' => 50,
    ];

    public $rating;
    public $grades = [];
    private $dealJacketGrades;
    private $glbaGrades;
    private $oshaGrades;
    private $bodyShopGrades;

    public function mount()
    {
        $this->loadGrades();
        $this->calculateOverallRating();
    }

    public function getDealJacketRatingProperty(): ?string
    {
        return $this->calculateGrade($this->dealJacketGrades);
    }

    public function getGlbaRatingProperty(): ?string
    {
        return $this->calculateGrade($this->glbaGrades);
    }

    public function getOshaRatingProperty(): ?string
    {
        return $this->calculateGrade($this->oshaGrades);
    }

    public function getBodyShopRatingProperty(): ?string
    {
        return $this->calculateGrade($this->bodyShopGrades);
    }

    public function getGradeLetterProperty(): string
    {
        return $this->rating ?? 'N/A';
    }

    public function render()
    {
        return view('livewire.dealer.home.group-rating');
    }

    private function loadGrades(): void
    {
        $this->dealJacketGrades = Cache::remember(
            'group_deal_jacket_grades',
            now()->addHour(),
            fn () => $this->getGradesFromAudit(IndividualAudit::class, 'rating')
        );

        $this->glbaGrades = Cache::remember(
            'group_glba_grades',
            now()->addHour(),
            fn () => $this->getGradesFromAudit(GlbaViolationAudit::class, 'grade')
        );

        $this->oshaGrades = Cache::remember(
            'group_osha_grades',
            now()->addHour(),
            fn () => $this->getGradesFromAudit(OshaViolationAudit::class, 'grade')
        );

        $this->bodyShopGrades = Cache::remember(
            'group_body_shop_grades',
            now()->addHour(),
            fn () => $this->getGradesFromAudit(BodyShopViolationAudit::class, 'grade')
        );

        $this->grades = array_merge(
            $this->dealJacketGrades,
            $this->glbaGrades,
            $this->oshaGrades,
            $this->bodyShopGrades
        );
    }

    private function getGradesFromAudit(string $auditClass, string $column): array
    {
        return $auditClass::query()
            ->whereNotNull($column)
            ->pluck($column)
            ->toArray();
    }

    private function calculateOverallRating(): void
    {
        $this->rating = $this->calculateGrade($this->grades);
    }

    private function calculateGrade(array $grades): ?string
    {
        if (empty($grades)) {
            return null;
        }

        $numericGrades = $this->convertToNumericGrades($grades);
        $averageGrade = array_sum($numericGrades) / count($numericGrades);

        return $this->getLetterGrade($averageGrade);
    }

    private function convertToNumericGrades(array $grades): array
    {
        return array_map(fn ($grade) => is_numeric($grade) ? $grade : (self::GRADE_VALUES[$grade] ?? 0), $grades);
    }

    private function getLetterGrade(float $grade): string
    {
        if ($grade >= 90) {
            return 'A';
        }
        if ($grade >= 80) {
            return 'B';
        }
        if ($grade >= 70) {
            return 'C';
        }
        if ($grade >= 60) {
            return 'D';
        }

        return 'F';
    }
}
