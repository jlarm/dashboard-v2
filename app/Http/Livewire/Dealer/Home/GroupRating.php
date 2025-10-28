<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class GroupRating extends Component
{
    private const GRADE_VALUES = [
        'A' => 90,
        'B' => 80,
        'C' => 70,
        'D' => 60,
        'F' => 50,
    ];

    public bool $isLoading = true;
    public ?string $rating = null;

    /** @var array<int, float|int|string> */
    public array $dealJacketGrades = [];

    /** @var array<int, float|int|string> */
    public array $glbaGrades = [];

    /** @var array<int, float|int|string> */
    public array $oshaGrades = [];

    /** @var array<int, float|int|string> */
    public array $bodyShopGrades = [];

    public function loadRatings(): void
    {
        $user = auth()->user();

        if (auth()->user()->hasAnyRole(['super-admin', 'Consultant'])) {
            $storeIds = Cache::remember('all_store_ids', 86400, fn () => Store::pluck('id'));
        } else {
            $cacheKey = "user_{$user->id}_store_ids";
            $storeIds = Cache::remember($cacheKey, 3600, fn () => auth()->user()->stores()->pluck('id'));
        }

        $cacheTime = 3600;

        $gradesCacheKey = 'ratings_by_stores_'.md5(implode(',', $storeIds->toArray()));

        $allGradesData = Cache::remember($gradesCacheKey, $cacheTime, function () use ($storeIds) {
            $this->dealJacketGrades = IndividualAudit::query()
                ->whereIn('store_id', $storeIds)
                ->whereNotNull('rating')
                ->pluck('rating')
                ->toArray();

            $this->glbaGrades = GlbaViolationAudit::query()
                ->whereIn('store_id', $storeIds)
                ->whereNotNull('grade')
                ->pluck('grade')
                ->toArray();

            $this->oshaGrades = OshaViolationAudit::query()
                ->whereIn('store_id', $storeIds)
                ->whereNotNull('grade')
                ->pluck('grade')
                ->toArray();

            $this->bodyShopGrades = BodyShopViolationAudit::query()
                ->whereIn('store_id', $storeIds)
                ->whereNotNull('grade')
                ->pluck('grade')
                ->toArray();

            return [
                'dealJacketGrades' => $this->dealJacketGrades,
                'glbaGrades' => $this->glbaGrades,
                'oshaGrades' => $this->oshaGrades,
                'bodyShopGrades' => $this->bodyShopGrades,
            ];
        });

        $allGrades = array_merge(
            $this->dealJacketGrades = $allGradesData['dealJacketGrades'],
            $this->glbaGrades = $allGradesData['glbaGrades'],
            $this->oshaGrades = $allGradesData['oshaGrades'],
            $this->bodyShopGrades = $allGradesData['bodyShopGrades'],
        );

        $this->rating = $this->calculateGrade($allGrades);

        $this->isLoading = false;
    }

    public function getDealJacketRatingProperty(): ?string
    {
        return $this->calculateGrade(collect($this->dealJacketGrades));
    }

    public function getGlbaRatingProperty(): ?string
    {
        return $this->calculateGrade(collect($this->glbaGrades));
    }

    public function getOshaRatingProperty(): ?string
    {
        return $this->calculateGrade(collect($this->oshaGrades));
    }

    public function getBodyShopRatingProperty(): ?string
    {
        return $this->calculateGrade(collect($this->bodyShopGrades));
    }

    public function render()
    {
        return view('livewire.dealer.home.group-rating');
    }

    private function calculateGrade(Collection|array $grades): ?string
    {
        $grades = collect($grades);

        if ($grades->isEmpty()) {
            return null;
        }

        $numericGrades = $grades->map(fn ($grade) => is_numeric($grade) ? (float) $grade : (self::GRADE_VALUES[$grade] ?? 0));

        $averageGrade = $numericGrades->avg();

        return $this->getLetterGrade($averageGrade);
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
