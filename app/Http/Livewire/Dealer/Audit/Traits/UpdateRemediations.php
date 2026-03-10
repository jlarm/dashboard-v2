<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Traits;

use App\Models\Remediation;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Livewire\TemporaryUploadedFile;
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
            $hasQualifyingAttributes = ($comment !== '' && $comment !== '0') || $completed;

            $hasNewPhoto = $newPhoto !== null;
            $remediation = $violation->remediation ?? new Remediation(['violation_id' => $violationId]);
            $isNewRemediation = ! $remediation->exists;

            $isDirty = false;
            $newPhotoSuccessfullyAdded = false;

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
                    if (! $newPhoto || ! method_exists($newPhoto, 'getRealPath')) {
                        Log::warning('Invalid remediation photo object', [
                            'violation_id' => $violationId,
                        ]);

                        continue;
                    }

                    $filePath = $newPhoto->getRealPath();

                    if (! $filePath || ! file_exists($filePath) || ! is_readable($filePath)) {
                        $originalName = method_exists($newPhoto, 'getClientOriginalName')
                            ? $newPhoto->getClientOriginalName()
                            : null;
                        Log::warning('Remediation photo file does not exist or is not readable', [
                            'violation_id' => $violationId,
                            'file_path' => $filePath,
                            'original_name' => $originalName,
                        ]);

                        unset($this->violationRemediations[$violationId]['photo']);

                        continue;
                    }

                    if (filesize($filePath) === 0) {
                        Log::warning('Remediation photo file is empty (0 bytes)', [
                            'violation_id' => $violationId,
                            'file_path' => $filePath,
                        ]);

                        continue;
                    }

                    if ($isNewRemediation) {
                        $remediation->user_id = auth()->id();
                        $remediation->save();
                        $isNewRemediation = false;
                    }

                    $remediation->addMedia($filePath)->toMediaCollection('remediations', 'armpaudits');
                    $isDirty = true;
                    $newPhotoSuccessfullyAdded = true;
                } catch (FileDoesNotExist $e) {
                    Log::warning('Spatie MediaLibrary could not find the file', [
                        'violation_id' => $violationId,
                        'error' => $e->getMessage(),
                    ]);

                    unset($this->violationRemediations[$violationId]['photo']);
                } catch (Exception $e) {
                    Log::error('Failed to add remediation photo', [
                        'violation_id' => $violationId,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);

                    unset($this->violationRemediations[$violationId]['photo']);
                }
            }

            $finalComment = $remediation->comment;
            $finalCompleted = $remediation->completed;
            $willHavePhotos = $newPhotoSuccessfullyAdded;

            if (! $isNewRemediation) {
                $willHavePhotos = $willHavePhotos || $remediation->getMedia('remediations')->isNotEmpty();
            }

            $hasQualifyingContent = ($finalComment !== '' && $finalComment !== '0') || $finalCompleted || $willHavePhotos;

            if ($isNewRemediation) {
                if ($hasQualifyingContent) {
                    $remediation->user_id = auth()->id();
                    $remediation->save();
                }
            } elseif ($hasQualifyingContent) {
                if ($isDirty) {
                    $remediation->user_id = auth()->id();
                    $remediation->save();
                }
            } else {
                $remediation->delete();
            }
        }

        Notification::make()
            ->title('Remediation Updated Successfully!')
            ->success()
            ->send();
    }

    public function removeTemporaryPhoto(int $violationId): void
    {
        $this->violationRemediations[$violationId]['photo'] = null;
    }

    public function temporaryPhotoPreviewUrl(mixed $photo): ?string
    {
        if (! $photo instanceof TemporaryUploadedFile && (! is_object($photo) || ! method_exists($photo, 'temporaryUrl'))) {
            return null;
        }

        try {
            return $photo->temporaryUrl();
        } catch (Exception) {
            return null;
        }
    }

    public function removeUploadedPhoto(int $violationId): void
    {
        try {
            $this->askForConfirmation(
                callback: fn () => $this->handlePhotoRemoval($violationId),
                prompt: [
                    'title' => 'Remove Photo',
                    'message' => 'Are you sure you want to remove this photo?',
                ]
            );
        } catch (Exception $e) {
            Log::error('Failed to remove photo: '.$e->getMessage());
            Notification::make()
                ->title('Error Initiating Removal')
                ->body('There was an issue initiating the photo removal. Please try again.')
                ->danger()
                ->send();
        }
    }

    private function handlePhotoRemoval(int $violationId): void
    {
        $remediation = $this->violations()->find($violationId)?->remediation;

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
