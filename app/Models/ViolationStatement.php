<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ViolationStatementCategory;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Override;

/**
 * @property-read int $id
 * @property-read string $statement
 * @property-read array<int, string>|null $keywords
 * @property-read int $weight
 * @property-read Collection<int, ViolationStatementCategory> $categories
 * @property-read string|null $reference_image_url
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
class ViolationStatement extends Model
{
    /**
     * @use HasFactory<\Database\Factories\ViolationStatementFactory>
     */
    use HasFactory;

    #[Override]
    protected $fillable = [
        'statement',
        'keywords',
        'weight',
        'categories',
        'reference_image_url',
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'statement' => 'string',
            'keywords' => 'array',
            'weight' => 'integer',
            'categories' => AsEnumCollection::of(ViolationStatementCategory::class),
            'reference_image_url' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
