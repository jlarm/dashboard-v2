<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

/**
 * @property int $id
 * @property string|null $short_name
 * @property string|null $instance_id
 * @property string|null $instance_url
 */
class Cyrisma extends Model
{
    #[Override]
    protected $fillable = [
        'store_id',
        'short_name',
        'instance_id',
        'instance_url',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'instance_id' => 'encrypted',
            'instance_url' => 'encrypted',
        ];
    }
}
