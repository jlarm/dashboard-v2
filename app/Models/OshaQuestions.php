<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\OshaQuestionsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Override;

class OshaQuestions extends Model
{
    /**
     * @use HasFactory<OshaQuestionsFactory>
     */
    use HasFactory;

    #[Override]
    protected $fillable = [
        'question',
    ];
}
