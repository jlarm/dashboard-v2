<?php

declare(strict_types=1);

namespace App\Models\Dealer\Audit\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 * @property string $uuid
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $completed_date
 * @property string|null $grade
 * @property int|null $outstanding_remediation_count
 * @property string|null $remediation_pdf_path
 * @property array<int, string>|null $reminder_logs
 * @property int|null $violations_count
 * @property-read \App\Models\Dealer\Store|null $store
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Dealer\Violation> $violations
 */
interface ViolationAudit
{
    public function user(): BelongsTo;

    public function gradeUpdatedBy(): BelongsTo;

    public function store(): BelongsTo;

    public function violations(): MorphMany;

    public function reminders(): MorphMany;

    public function auditComments(): MorphMany;
}
