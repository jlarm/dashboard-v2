<?php

declare(strict_types=1);

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MoneyCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return round((float) $value / 100, 2);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return round((float) $value * 100, 0);
    }
}
