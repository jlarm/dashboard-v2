<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property array|null $product_identification_numbers
 * @property array|null $cas_nos
 */
class Sds extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'product_identifier',
        'product_identification_numbers',
        'manufacturer',
        'cas_nos',
        'common_name',
        'pdf_path',
        'keywords',
        'file_name',
    ];
    protected $casts = [
        'product_identification_numbers' => 'array',
        'cas_nos' => 'array',
        'keywords' => 'array',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function ($model): void {
            $model->uuid = (string) Str::uuid();
        });
    }
}
