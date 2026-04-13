<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Str;

trait HasGlbaViolationStatements
{
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function violationSelected(array $violation): void
    {
        $this->persistCurrentViolations();

        $this->glbaViolationAudit->violations()->create([
            'statement_id' => $violation['id'],
            'statement' => $violation['statement'],
            'uuid' => Str::uuid(),
            'risk' => false,
        ]);

        $this->violations = $this->glbaViolationAudit->violations()->get();
    }

    public function deletePhoto($id, $position): void
    {
        $this->askForConfirmation(
            callback: function () use ($id, $position): void {
                $this->glbaViolationAudit->violations()->where('id', $id)->first()->clearMediaCollection('violation_files_'.$position);

                $this->violations = $this->glbaViolationAudit->violations()->get();
            },
            prompt: [
                'title' => 'Delete Photo',
                'message' => 'Are you sure you want to delete this photo?',
                'confirm' => 'Yes, delete',
                'cancel' => 'No, cancel',
            ],
        );
    }

    public function deleteViolation($violationId): void
    {
        $this->askForConfirmation(
            callback: function () use ($violationId): void {
                $violation = $this->glbaViolationAudit->violations()->where('id', $violationId)->first();

                $violation->clearMediaCollection('violations_files_0');
                $violation->clearMediaCollection('violations_files_1');
                $violation->clearMediaCollection('violations_files_2');

                $violation->delete();

                $this->violations = $this->glbaViolationAudit->violations()->get();
            },
            prompt: [
                'title' => 'Delete Violation ',
                'message' => 'Are you sure you want to delete this violation?',
                'confirm' => 'Yes, delete',
                'cancel' => 'No, cancel',
            ],
        );
    }

    private function persistCurrentViolations(): void
    {
        foreach ($this->violations as $violation) {
            $violation->update([
                'comment' => $violation['comment'] ?? '',
                'violation_date' => $violation['violation_date'] ?? null,
                'risk' => $violation['risk'] ?? false,
                'severity' => $violation['severity'] ?? null,
                'show_reference_image' => (bool) ($violation['show_reference_image'] ?? false),
            ]);
        }
    }
}
