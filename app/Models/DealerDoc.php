<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DealerDoc extends Model
{
    protected $fillable = [
        'title',
        'store_id',
        'url',
        'file_name',
        'file_path',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
