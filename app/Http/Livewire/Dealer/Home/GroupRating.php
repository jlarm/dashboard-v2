<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\{
    IndividualAudit,
    GlbaViolationAudit,
    OshaViolationAudit,
    BodyShopViolationAudit
};
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class GroupRating extends Component
{
    public $rating;
    public $grades = [];
    private $dealJacketGrades;
    private $glbaGrades;
    private $oshaGrades;
    private $bodyShopGrades;

    private const array GRADE_VALUES = [
        'A' => 90,
        'B' => 80,
        'C' => 70,
        'D' => 60,
        'F' => 50
    ];

    private const int CACHE_TTL = 3600; // 1 hour in seconds

    public function mount()
    {
        $this->loadGrades();
        $this->calculateOverallRating();
    }

    private function loadGrades(): void
    {
        $this->dealJacketGrades = $this->getCachedGrades('dealJacket', IndividualAudit::class, 'rating');
        $this->glbaGrades = $this->getCachedGrades('glba', GlbaViolationAudit::class, 'grade');
        $this->oshaGrades = $this->getCachedGrades('osha', OshaViolationAudit::class, 'grade');
        $this->bodyShopGrades = $this->getCachedGrades('bodyShop', BodyShopViolationAudit::class, 'grade');

        $this->grades = array_merge(
            $this->dealJacketGrades,
            $this->glbaGrades,
            $this->oshaGrades,
            $this->bodyShopGrades
        );
    }

    private function getCachedGrades(string $key, string $auditClass, string $column): array
    {
        return Cache::remember("grades.{$key}", self::CACHE_TTL, function () use ($auditClass, $column) {
            return $this->getGradesFromAudit($auditClass, $column);
        });
    }

    private function getGradesFromAudit(string $auditClass, string $column): array
    {
        return $auditClass::whereNotNull($column)->pluck($column)->toArray();
    }

    private function calculateOverallRating(): void
    {
        $this->rating = Cache::remember('overall.rating', self::CACHE_TTL, function () {
            return $this->calculateGrade($this->grades);
        });
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
        return array_map(function ($grade) {
            return is_numeric($grade) ? $grade : (self::GRADE_VALUES[$grade] ?? 0);
        }, $grades);
    }

    private function getLetterGrade(float $grade): string
    {
        if ($grade >= 90) return 'A';
        if ($grade >= 80) return 'B';
        if ($grade >= 70) return 'C';
        if ($grade >= 60) return 'D';
        return 'F';
    }

    public function getDealJacketRatingProperty(): ?string
    {
        return Cache::remember('rating.dealJacket', self::CACHE_TTL, function () {
            return $this->calculateGrade($this->dealJacketGrades);
        });
    }

    public function getGlbaRatingProperty(): ?string
    {
        return Cache::remember('rating.glba', self::CACHE_TTL, function () {
            return $this->calculateGrade($this->glbaGrades);
        });
    }

    public function getOshaRatingProperty(): ?string
    {
        return Cache::remember('rating.osha', self::CACHE_TTL, function () {
            return $this->calculateGrade($this->oshaGrades);
        });
    }

    public function getBodyShopRatingProperty(): ?string
    {
        return Cache::remember('rating.bodyShop', self::CACHE_TTL, function () {
            return $this->calculateGrade($this->bodyShopGrades);
        });
    }

    public function getGradeLetterProperty(): string
    {
        return $this->rating ?? 'N/A';
    }

    public function render()
    {
        return view('livewire.dealer.home.group-rating');
    }
}
