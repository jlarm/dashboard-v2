<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\GlbaViolationStatements;
use Illuminate\Support\Str;

trait HasGlbaViolationStatements
{
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function violationSelected(array $violation): void
    {
        $this->violationStatements = tenancy()->central(fn ($tenant) => GlbaViolationStatements::all());

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
}
