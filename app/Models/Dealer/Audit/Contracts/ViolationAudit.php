<?php

declare(strict_types=1);

namespace App\Models\Dealer\Audit\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ViolationAudit
{
    public function user(): BelongsTo;

    public function gradeUpdatedBy(): BelongsTo;

    public function store(): BelongsTo;

    public function violations(): MorphMany;

    public function reminders(): MorphMany;

    public function auditComments(): MorphMany;
}
