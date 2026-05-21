<?php

declare(strict_types=1);

namespace App\Models\Dealer\Audit\Contracts;

use App\Models\AuditComment;
use App\Models\Dealer\Store;
use App\Models\Dealer\Violation;
use App\Models\RemediationReminders;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $uuid
 * @property Carbon $date
 * @property Carbon|null $completed_date
 * @property string|null $grade
 * @property int|null $outstanding_remediation_count
 * @property string|null $remediation_pdf_path
 * @property array<int, string>|null $reminder_logs
 * @property int|null $violations_count
 * @property-read Store|null $store
 * @property-read Collection<int, Violation> $violations
 */
interface ViolationAudit
{
    /**
     * @return BelongsTo<User, Model>
     */
    public function user(): BelongsTo;

    /**
     * @return BelongsTo<User, Model>
     */
    public function gradeUpdatedBy(): BelongsTo;

    /**
     * @return BelongsTo<Store, Model>
     */
    public function store(): BelongsTo;

    /**
     * @return MorphMany<Violation, Model>
     */
    public function violations(): MorphMany;

    /**
     * @return MorphMany<RemediationReminders, Model>
     */
    public function reminders(): MorphMany;

    /**
     * @return MorphMany<AuditComment, Model>
     */
    public function auditComments(): MorphMany;
}
