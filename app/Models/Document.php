<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Override;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property-read int $id
 * @property-read string $title
 * @property-read ?string $url
 * @property-read ?string $file_name
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
class Document extends Model
{
    /**
     * @use HasFactory<\Database\Factories\DocumentFactory>
     */
    use HasFactory, LogsActivity;

    #[Override]
    protected $fillable = [
        'title',
        'url',
        'file_name',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
