<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class FinanceQuestions extends Model
{
    #[Override]
    protected $fillable = [
        'question',
    ];
}
