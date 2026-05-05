<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class ComplianceScoreSnapshot extends Model
{
    #[Override]
    protected $fillable = [
        'store_id',
        'scored_on',
        'score',
        'pillars',
        'weights',
        'overdue_count',
        'overdue_high_severity_count',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'scored_on' => 'date',
            'score' => 'float',
            'pillars' => 'array',
            'weights' => 'array',
            'overdue_count' => 'integer',
            'overdue_high_severity_count' => 'integer',
        ];
    }
}
