<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ridgeback extends Model
{
    protected $fillable = [
        'store_id',
        'ip_address',
        'active',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }
}
