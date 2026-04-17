<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class FitTestDoc extends Model
{
    #[Override]
    protected $fillable = [
        'store_id',
        'user_id',
        'employee_name',
        'date',
        'file_path',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'store_id' => 'integer',
            'user_id' => 'integer',
            'employee_name' => 'string',
            'date' => 'date',
            'file_path' => 'string',
        ];
    }
}
