<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\Dealer\Violation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class UpdateViolationAudit
{
    /**
     * @param  array{date: string, violations: array<int, array{id: int, comment: string, violation_date: ?string, risk: bool, severity: ?int, show_reference_image: bool, images?: array<int, UploadedFile>}>}  $data
     */
    public function handle(ViolationAudit&Model $audit, array $data): void
    {
        $audit->update(['date' => $data['date']]);

        foreach ($data['violations'] as $violationData) {
            /** @var Violation|null $violation */
            $violation = $audit->violations()->whereKey($violationData['id'])->first();
            if ($violation === null) {
                continue;
            }

            $violation->update([
                'comment' => $violationData['comment'],
                'violation_date' => $violationData['violation_date'] ?? null,
                'risk' => $violationData['risk'],
                'severity' => $violationData['severity'] ?? null,
                'show_reference_image' => $violationData['show_reference_image'],
            ]);

            $images = $violationData['images'] ?? [];
            if (empty($images)) {
                continue;
            }

            foreach ($images as $image) {
                $position = $this->nextEmptyPhotoSlot($violation);
                if ($position === null) {
                    break;
                }

                $violation->addMedia($image->getRealPath())
                    ->usingFileName($image->getClientOriginalName())
                    ->toMediaCollection('violation_files_'.$position, 'armpaudits');

                $violation->load('media');
            }
        }
    }

    private function nextEmptyPhotoSlot(Violation $violation): ?int
    {
        foreach ([0, 1, 2] as $position) {
            if ($violation->getMedia('violation_files_'.$position)->isEmpty()) {
                return $position;
            }
        }

        return null;
    }
}
