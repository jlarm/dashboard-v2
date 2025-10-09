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

    private const int CACHE_TTL = 3600; // 1 hour in seconds

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
        return Cache::remember('rating.dealJacket', self::CACHE_TTL, fn () => $this->calculateGrade($this->dealJacketGrades));
    }

    public function getGlbaRatingProperty(): ?string
    {
        return Cache::remember('rating.glba', self::CACHE_TTL, fn () => $this->calculateGrade($this->glbaGrades));
    }

    public function getOshaRatingProperty(): ?string
    {
        return Cache::remember('rating.osha', self::CACHE_TTL, fn () => $this->calculateGrade($this->oshaGrades));
    }

    public function getBodyShopRatingProperty(): ?string
    {
        return Cache::remember('rating.bodyShop', self::CACHE_TTL, fn () => $this->calculateGrade($this->bodyShopGrades));
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
        return Cache::remember("grades.{$key}", self::CACHE_TTL, fn () => $this->getGradesFromAudit($auditClass, $column));
    }

    private function getGradesFromAudit(string $auditClass, string $column): array
    {
        return $auditClass::whereNotNull($column)->pluck($column)->toArray();
    }

    private function calculateOverallRating(): void
    {
        $this->rating = Cache::remember('overall.rating', self::CACHE_TTL, fn () => $this->calculateGrade($this->grades));
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
