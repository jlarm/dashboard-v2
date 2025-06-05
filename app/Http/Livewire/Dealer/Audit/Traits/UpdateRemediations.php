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
            $completed = $remediationData['completed'] ?? false;
            $newPhoto = $remediationData['photo'] ?? null;

            $hasNewPhoto = !empty($newPhoto);
            $remediation = $violation->remediation ?? new Remediation(['violation_id' => $violationId]);

            $isDirty = false;
            $newPhotoSuccessfullyAdded = false; // Initialize flag for successful photo addition

            if ($remediation->comment !== $comment) {
                $remediation->comment = $comment;
                $isDirty = true;
            }

            if ($completed !== $remediation->completed) {
                $remediation->completed = $completed;
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
                    $newPhotoSuccessfullyAdded = true; // Mark photo as successfully added
                    
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

            $isNewRemediation = !$remediation->exists; // Check if it was new before any potential save

            // Current state of remediation after potential updates to ->comment and ->completed
            $finalComment = $remediation->comment;
            $finalCompleted = $remediation->completed;

            // Determine if it will have photos after this operation
            $willHavePhotos = $newPhotoSuccessfullyAdded;
            if (!$newPhotoSuccessfullyAdded && !$isNewRemediation) {
                // If no new photo was successfully added, and it's an existing remediation,
                // check if it already has photos. This assumes getMedia reflects current photos
                // and this code block doesn't handle explicit photo removal.
                $willHavePhotos = $willHavePhotos || $remediation->getMedia('remediations')->isNotEmpty();
            }

            $hasQualifyingContent = !empty($finalComment) || $finalCompleted || $willHavePhotos;

            if ($isNewRemediation) {
                // For a new remediation instance
                if ($hasQualifyingContent) {
                    // If it has qualifying content, save it (create it in DB)
                    $remediation->user_id = auth()->id();
                    $remediation->save();
                }
                // Else: new instance, but no qualifying content. Do not save.
            } else {
                // For an existing remediation instance
                if ($hasQualifyingContent) {
                    // It has qualifying content. If any attributes were changed ($isDirty), save the updates.
                    if ($isDirty) {
                        $remediation->user_id = auth()->id();
                        $remediation->save();
                    }
                    // Else: existing, has content, but not dirty. No changes to save.
                } else {
                    // It's an existing remediation, but it no longer has qualifying content.
                    // So, delete it from the DB.
                    $remediation->delete();
                }
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
