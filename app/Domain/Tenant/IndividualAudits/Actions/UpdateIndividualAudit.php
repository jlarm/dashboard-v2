<?php

declare(strict_types=1);

namespace App\Domain\Tenant\IndividualAudits\Actions;

use App\Models\Dealer\Audit\IndividualAudit;
use Illuminate\Http\UploadedFile;

class UpdateIndividualAudit
{
    /**
     * @param  array{
     *   draft: bool,
     *   audit_date: ?string,
     *   deal_jacket_date: ?string,
     *   customer_name: ?string,
     *   customer_number: ?string,
     *   manager_id: ?int,
     *   mileage: ?string,
     *   answers: array<int, array{answer: ?string, comment: ?string, danger: bool}>,
     *   new_images: array<int, UploadedFile>,
     *   remove_image_ids: array<int, int>,
     * }  $data
     */
    public function handle(IndividualAudit $audit, array $data): void
    {
        $attributes = [
            'draft' => $data['draft'],
            'audit_date' => $data['audit_date'],
            'deal_jacket_date' => $data['deal_jacket_date'],
            'customer_name' => $data['customer_name'],
            'customer_number' => $data['customer_number'],
            'manager_id' => $data['manager_id'],
            'mileage' => $data['mileage'],
        ];

        foreach ($data['answers'] as $questionId => $row) {
            $attributes["individual_q{$questionId}_answer"] = $row['answer'];
            $attributes["individual_q{$questionId}_comment"] = $row['comment'];
            $attributes["individual_q{$questionId}_danger"] = $row['danger'];
        }

        $audit->update($attributes);

        foreach ($data['remove_image_ids'] as $mediaId) {
            $audit->media()
                ->where('id', $mediaId)
                ->where('collection_name', 'individual_audit_images')
                ->first()
                ?->delete();
        }

        foreach ($data['new_images'] as $file) {
            $audit->addMedia($file)->toMediaCollection('individual_audit_images', 'digitalocean');
        }
    }
}
