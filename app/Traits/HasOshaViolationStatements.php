<?php

namespace App\Traits;

use App\Models\OshaViolationStatements;
use Str;

trait HasOshaViolationStatements
{
    public function updated($propertyName): void
    {
        if ($propertyName) {
            $this->validateOnly($propertyName);
        }
    }

    public function violationSelected($violation): void
    {
        $this->violationStatements = tenancy()->central(function ($tenant) {
            return OshaViolationStatements::all();
        });

        $this->oshaViolationAudit->violations()->create([
            'statement_id' => $violation['id'],
            'statement' => $violation['statement'],
            'uuid' => Str::uuid(),
            'risk' => false,
        ]);

        $this->violations = $this->oshaViolationAudit->violations()->get();
    }

    public function deletePhoto($id, $position): void
    {
        $this->askForConfirmation(
            callback: function () use ($id, $position) {
                $this->oshaViolationAudit->violations()->where('id', $id)->first()->clearMediaCollection('violation_files_'.$position);

                $this->violations = $this->oshaViolationAudit->violations()->get();
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
            callback: function () use ($violationId) {
                $violation = $this->oshaViolationAudit->violations()->where('id', $violationId)->first();

                $violation->clearMediaCollection('violations_files_0');
                $violation->clearMediaCollection('violations_files_1');
                $violation->clearMediaCollection('violations_files_2');

                $violation->delete();

                $this->violations = $this->oshaViolationAudit->violations()->get();
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
