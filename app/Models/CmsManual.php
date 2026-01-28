<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsManual extends Model
{
    protected $fillable = [
        'user_id',
        'store_id',
        'qi_name',
        'standard_dpp_rate',
        'adoption_approval_name_one',
        'adoption_approval_signature_one',
        'adoption_approval_name_two',
        'adoption_approval_signature_two',
        'adoption_approval_name_three',
        'adoption_approval_signature_three',
        'dealer_participation_program_name',
        'dealer_participation_program_signature',
        'appointment_program_name_one',
        'appointment_program_signature_one',
        'appointment_program_name_two',
        'appointment_program_signature_two',
        'appointment_program_name_three',
        'appointment_program_signature_three',
        'acknowledgement_name',
        'acknowledgement_signature',
        'pdf_path',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Dealer\Store::class);
    }
}
