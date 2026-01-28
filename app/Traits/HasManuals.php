<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManuals
{
    public function isps(): HasMany
    {
        return $this->hasMany(Isp::class);
    }

    public function oshas(): HasMany
    {
        return $this->hasMany(Osha::class);
    }

    public function redflags(): HasMany
    {
        return $this->hasMany(RedFlag::class);
    }
}
