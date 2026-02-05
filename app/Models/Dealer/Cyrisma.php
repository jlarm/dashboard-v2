<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cyrisma extends Model
{
    protected $fillable = [
        'store_id',
        'short_name',
        'instance_id',
        'instance_url',
    ];
    protected $casts = [
        'instance_id' => 'encrypted',
        'instance_url' => 'encrypted',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
