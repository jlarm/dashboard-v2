<?php

declare(strict_types=1);

namespace App\Models\Dealer\Audit\Contracts;

use App\Models\Dealer\Store;
use App\Models\Dealer\Violation;
use Illuminate\Database\Eloquent\Collection;
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
    public function user(): BelongsTo;

    public function gradeUpdatedBy(): BelongsTo;

    public function store(): BelongsTo;

    public function violations(): MorphMany;

    public function reminders(): MorphMany;

    public function auditComments(): MorphMany;
}
