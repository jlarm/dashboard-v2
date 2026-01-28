<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sds extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'manufacturer',
        'keywords',
        'file_name',
    ];
    protected $casts = [
        'keywords' => 'array',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}
