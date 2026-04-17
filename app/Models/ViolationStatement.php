<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ViolationStatementCategory;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read string $statement
 * @property-read array|null $keywords
 * @property-read int $weight
 * @property-read ViolationStatementCategory[] $categories
 * @property-read string|null $reference_image_url
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
class ViolationStatement extends Model
{
    use HasFactory;

    protected $fillable = [
        'statement',
        'keywords',
        'weight',
        'categories',
        'reference_image_url',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'statement' => 'string',
            'keywords' => 'array',
            'weight' => 'integer',
            'categories' => 'array',
            'reference_image_url' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
