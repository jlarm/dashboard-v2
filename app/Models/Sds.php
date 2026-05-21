<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Override;

/**
 * @property array<int, string>|null $product_identification_numbers
 * @property array<int, string>|null $cas_nos
 */
class Sds extends Model
{
    /**
     * @use HasFactory<\Database\Factories\SdsFactory>
     */
    use HasFactory;

    #[Override]
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

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function (self $model): void {
            $model->uuid = (string) Str::uuid();
        });
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'product_identification_numbers' => 'array',
            'cas_nos' => 'array',
            'keywords' => 'array',
        ];
    }
}
