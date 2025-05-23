<?php

namespace App\Http\Livewire\Dealer\Audit\Traits;

use App\Models\Remediation;
use Exception;
use Filament\Notifications\Notification;
use Log;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;

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
                try {
                    // Make sure the file object is valid and has a path
                    if (!$newPhoto || !method_exists($newPhoto, 'getRealPath')) {
                        Log::warning('Invalid remediation photo object', [
                            'violation_id' => $violationId
                        ]);
                        continue; // Skip this photo
                    }
                    
                    $filePath = $newPhoto->getRealPath();
                    
                    // Verify file exists and is readable
                    if (!$filePath || !file_exists($filePath) || !is_readable($filePath)) {
                        Log::warning('Remediation photo file does not exist or is not readable', [
                            'violation_id' => $violationId,
                            'file_path' => $filePath,
                            'original_name' => $newPhoto->getClientOriginalName()
                        ]);
                        
                        // Clean up the reference to prevent further errors
                        unset($this->violationRemediations[$violationId]['photo']);
                        continue; // Skip this photo
                    }
                    
                    // Validate file size (prevent 0 byte files)
                    if (filesize($filePath) === 0) {
                        Log::warning('Remediation photo file is empty (0 bytes)', [
                            'violation_id' => $violationId,
                            'file_path' => $filePath
                        ]);
                        continue; // Skip this photo
                    }
                    
                    $remediation->addMedia($filePath)->toMediaCollection('remediations', 'armpaudits');
                    $isDirty = true;
                    
                } catch (FileDoesNotExist $e) {
                    // Specifically handle Spatie's FileDoesNotExist exception
                    Log::warning('Spatie MediaLibrary could not find the file', [
                        'violation_id' => $violationId,
                        'error' => $e->getMessage()
                    ]);
                    
                    // Clean up the reference to prevent UI errors
                    unset($this->violationRemediations[$violationId]['photo']);
                    
                } catch (Exception $e) {
                    Log::error('Failed to add remediation photo', [
                        'violation_id' => $violationId,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    // Clean up the reference to prevent UI errors
                    unset($this->violationRemediations[$violationId]['photo']);
                }
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
