<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

/**
 * @mixin Store
 */
trait HasGrade
{
    private const int GRADE_CACHE_TTL = 300;

    private const string NULL_GRADE_CACHE_VALUE = '__null_grade__';

    /**
     * @var array<string, string|null>
     */
    private array $resolvedGradeValues = [];

    public function clearGradeCache(?string $type = null): void
    {
        $types = $type !== null ? [$type] : ['osha', 'glba', 'body_shop', 'deal_jacket', 'overall'];

        foreach ($types as $gradeType) {
            Cache::forget($this->getGradeCacheKey($gradeType));
            unset($this->resolvedGradeValues[$gradeType]);
        }
    }

    protected function getOshaGradeAttribute(): ?string
    {
        return $this->latestAuditGrade('osha', $this->oshaViolationAudits());
    }

    protected function getGlbaGradeAttribute(): ?string
    {
        return $this->latestAuditGrade('glba', $this->glbaViolationAudits());
    }

    protected function getBodyShopGradeAttribute(): ?string
    {
        return $this->latestAuditGrade('body_shop', $this->bodyShopViolationAudits());
    }

    /**
     * @param  HasMany<covariant Model, covariant Model>  $audits
     */
    private function latestAuditGrade(string $type, HasMany $audits): ?string
    {
        return $this->rememberGradeValue(
            $type,
            function () use ($audits): ?string {
                $grade = $audits
                    ->whereNotNull('grade')
                    ->where('grade', '!=', 'N/A')
                    ->orderByDesc('date')
                    ->orderByDesc('id')
                    ->value('grade');

                return $grade !== null ? (string) $grade : null;
            },
        );
    }

    private function getGradeCacheKey(string $type): string
    {
        $tenantId = tenant('id') ?? 'no-tenant';

        return "store_{$this->id}_{$type}_grade_{$tenantId}";
    }

    private function rememberGradeValue(string $type, callable $resolver): ?string
    {
        if (array_key_exists($type, $this->resolvedGradeValues)) {
            return $this->resolvedGradeValues[$type];
        }

        $value = Cache::remember(
            $this->getGradeCacheKey($type),
            self::GRADE_CACHE_TTL,
            fn (): string => $resolver() ?? self::NULL_GRADE_CACHE_VALUE,
        );

        return $this->resolvedGradeValues[$type] = $value === self::NULL_GRADE_CACHE_VALUE ? null : $value;
    }
}
