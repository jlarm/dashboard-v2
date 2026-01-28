<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FitTestDoc extends Model
{
    protected $fillable = [
        'store_id',
        'user_id',
        'employee_name',
        'date',
        'file_path',
    ];
    protected $casts = [
        'store_id' => 'integer',
        'user_id' => 'integer',
        'employee_name' => 'string',
        'date' => 'date',
        'file_path' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
