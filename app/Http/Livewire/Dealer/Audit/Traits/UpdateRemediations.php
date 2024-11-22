<?php

namespace App\Http\Livewire\Dealer\Audit\Traits;

use App\Models\Remediation;
use Exception;
use Filament\Notifications\Notification;
use Log;

trait UpdateRemediations
{
    public function editRemediations(): void
    {
        $violations = $this->violations()->with('remediation')->get();

        foreach ($violations as $violation) {
            $violationId = $violation->id;
            $remediationData = $this->violationRemediations[$violationId] ?? [];

            $comment = $remediationData['comment'] ?? '';
            $newPhoto = $remediationData['photo'] ?? null;

            $hasNewPhoto = !empty($newPhoto);
            $remediation = $violation->remediation ?? new Remediation(['violation_id' => $violationId]);

            $isDirty = false;

            if ($remediation->comment !== $comment) {
                $remediation->comment = $comment;
                $isDirty = true;
            }

            if ($hasNewPhoto) {
                $remediation->addMedia($newPhoto->getRealPath())->toMediaCollection('remediations', 'armpaudits');
                $isDirty = true;
            }

            if ($isDirty) {
                $remediation->user_id = auth()->id();
                $remediation->save();
            } elseif ($remediation->exists && !$hasNewPhoto && empty($comment)) {
                $remediation->delete();
            }
        }

        Notification::make()
            ->title('Remediation Updated Successfully!')
            ->success()
            ->send();
    }

    public function removeTemporaryPhoto(int $validationId): void
    {
        $this->violationRemediations[$validationId]['photo'] = null;
    }

    public function removeUploadedPhoto(int $violationId): void
    {
        try {
            $this->askForConfirmation(
                callback: fn() => $this->handlePhotoRemoval($violationId),
                prompt: [
                    'title' => 'Remove Photo',
                    'message' => 'Are you sure you want to remove this photo?',
                ]
            );
        } catch (Exception $e) {
            Log::error('Failed to remove photo: ' . $e->getMessage());
            Notification::make()
                ->title('Error Initiating Removal')
                ->body('There was an issue initiating the photo removal. Please try again.')
                ->danger()
                ->send();
        }
    }

    private function handlePhotoRemoval(int $violationId): void
    {
        $remediation = $this->oshaViolationAudit->violations->find($violationId)?->remediation;

        if ($remediation) {
            $remediation->getFirstMedia('remediations')?->delete();
            $this->violationRemediations[$violationId]['photo'] = null;

            Notification::make()
                ->title('Photo Removed Successfully!')
                ->success()
                ->send();
        }
    }
}
