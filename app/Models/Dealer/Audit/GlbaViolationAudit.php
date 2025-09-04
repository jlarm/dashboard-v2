<?php

namespace App\Models\Dealer\Audit;

use App\Models\AuditComment;
use App\Models\Dealer\Store;
use App\Models\Dealer\Violation;
use App\Models\RemediationReminders;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GlbaViolationAudit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'store_id',
        'pdf_path',
        'remediation_pdf_path',
        'completed_date',
        'date',
        'grade',
        'reminder_logs',
    ];

    protected $casts = [
        'uuid' => 'string',
        'date' => 'date',
        'completed_date' => 'date',
        'data' => 'array',
        'reminder_logs' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function violations(): MorphMany
    {
        return $this->morphMany(Violation::class, 'violationable');
    }

    public function reminders(): MorphMany
    {
        return $this->morphMany(RemediationReminders::class, 'remindable');
    }

    public function auditComments(): MorphMany
    {
        return $this->morphMany(AuditComment::class, 'auditable');
    }

    public function getViolationCountAttribute(): int
    {
        return $this->violations()->count();
    }

    public function getRemediationCountAttribute(): int
    {
        return $this->violations()->whereHas('remediation', function ($query) {
            $query->where('completed', true);
        })->count();
    }

    public function getOutstandingRemediationCountAttribute(): int
    {
        return $this->violation_count - $this->remediation_count;
    }
}
