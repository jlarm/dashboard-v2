<?php

declare(strict_types=1);

namespace App\Models\Dealer\Audit;

use App\Models\AuditComment;
use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\Dealer\Store;
use App\Models\Dealer\Violation;
use App\Models\RemediationReminders;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Override;

/**
 * @property int $id
 * @property string $uuid
 * @property Carbon|null $date
 * @property Carbon|null $completed_date
 * @property string|null $grade
 * @property int|null $outstanding_remediation_count
 * @property string|null $remediation_pdf_path
 * @property array<int, string>|null $reminder_logs
 * @property-read Store|null $store
 * @property-read Collection<int, Violation> $violations
 */
class BodyShopViolationAudit extends Model implements ViolationAudit
{
    use SoftDeletes;

    #[Override]
    protected $fillable = [
        'uuid',
        'user_id',
        'store_id',
        'pdf_path',
        'remediation_pdf_path',
        'completed_date',
        'date',
        'grade',
        'grade_updated_by',
        'grade_updated_at',
        'reminder_logs',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gradeUpdatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'grade_updated_by');
    }

    /**
     * @return BelongsTo<Store, $this>
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * @return MorphMany<Violation, $this>
     */
    public function violations(): MorphMany
    {
        return $this->morphMany(Violation::class, 'violationable');
    }

    /**
     * @return MorphMany<RemediationReminders, $this>
     */
    public function reminders(): MorphMany
    {
        return $this->morphMany(RemediationReminders::class, 'remindable');
    }

    /**
     * @return MorphMany<AuditComment, $this>
     */
    public function auditComments(): MorphMany
    {
        return $this->morphMany(AuditComment::class, 'auditable');
    }

    protected function getViolationCountAttribute(): int
    {
        if (array_key_exists('violation_count', $this->attributes)) {
            return (int) $this->attributes['violation_count'];
        }

        return $this->violations()->count();
    }

    protected function getRemediationCountAttribute(): int
    {
        if (array_key_exists('remediation_count', $this->attributes)) {
            return (int) $this->attributes['remediation_count'];
        }

        return $this->violations()->whereHas('remediation', function (\Illuminate\Database\Eloquent\Builder $query): void {
            $query->where('completed', true);
        })->count();
    }

    protected function getOutstandingRemediationCountAttribute(): int
    {
        return $this->violation_count - $this->remediation_count;
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'uuid' => 'string',
            'date' => 'date',
            'completed_date' => 'date',
            'grade_updated_at' => 'datetime',
            'data' => 'array',
            'reminder_logs' => 'array',
        ];
    }
}
