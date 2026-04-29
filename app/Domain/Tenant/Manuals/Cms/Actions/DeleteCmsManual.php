<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\Cms\Actions;

use App\Models\CmsManual;
use Illuminate\Support\Facades\Storage;

class DeleteCmsManual
{
    public function handle(CmsManual $manual): void
    {
        if ($manual->pdf_path !== null && $manual->pdf_path !== '') {
            Storage::disk('do-manuals')->delete(tenant('id').'/cms/'.$manual->pdf_path);
        }

        $signatureFields = [
            'adoption_approval_signature_one',
            'adoption_approval_signature_two',
            'adoption_approval_signature_three',
            'dealer_participation_program_signature',
            'appointment_program_signature_one',
            'appointment_program_signature_two',
            'appointment_program_signature_three',
            'acknowledgement_signature',
        ];

        foreach ($signatureFields as $field) {
            $value = (string) ($manual->{$field} ?? '');
            if ($value !== '') {
                Storage::delete('cms-signatures/'.$value);
            }
        }

        $manual->delete();
    }
}
