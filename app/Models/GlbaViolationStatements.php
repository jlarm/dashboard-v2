<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read string $statement
 * @property-read array $keywords
 * @property-read int $weight
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
class GlbaViolationStatements extends Model
{
    protected $fillable = [
        'statement',
        'keywords',
        'weight',
    ];
    protected $casts = [
        'id' => 'integer',
        'statement' => 'string',
        'keywords' => 'array',
        'weight' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
