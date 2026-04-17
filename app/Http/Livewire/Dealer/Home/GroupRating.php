<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
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
            $storeIds = Cache::remember('all_store_ids', 86400, fn () => Store::query()->pluck('id'));
        } else {
            $cacheKey = "user_{$user->id}_store_ids";
            $storeIds = Cache::remember($cacheKey, 3600, fn () => auth()->user()->stores()->pluck('id'));
        }

        $cacheTime = 3600;

        $gradesCacheKey = 'ratings_by_stores_'.md5(implode(',', $storeIds->toArray()));

        $allGradesData = Cache::remember($gradesCacheKey, $cacheTime, function () use ($storeIds): array {
            $latestGroupIds = DealJacketGroup::query()
                ->whereIn('store_id', $storeIds)
                ->where('completed', true)
                ->orderByDesc('id')
                ->get()
                ->unique('store_id')
                ->pluck('id');

            $this->dealJacketGrades = DealJacket::query()
                ->whereIn('deal_jacket_group_id', $latestGroupIds)
                ->selectRaw('deal_jacket_group_id, AVG(percentage) as avg_percentage')
                ->groupBy('deal_jacket_group_id')
                ->pluck('avg_percentage')
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

    public function render(): Factory|View
    {
        return view('livewire.dealer.home.group-rating');
    }

    private function calculateGrade(Collection|array $grades): ?string
    {
        $grades = collect($grades);

        if ($grades->isEmpty()) {
            return null;
        }

        $numericGrades = $grades->map(fn ($grade): float|int => is_numeric($grade) ? (float) $grade : (self::GRADE_VALUES[$grade] ?? 0));

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
