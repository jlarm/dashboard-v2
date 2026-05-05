<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class TenantComplianceSnapshot extends Model
{
    #[Override]
    protected $fillable = [
        'scored_on',
        'expired_training_count',
        'expiring_soon_training_count',
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'scored_on' => 'date',
            'expired_training_count' => 'integer',
            'expiring_soon_training_count' => 'integer',
        ];
    }
}
