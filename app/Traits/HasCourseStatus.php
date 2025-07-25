<?php

namespace App\Traits;

trait HasCourseStatus
{
    public function status(): string
    {
        $expiryDate = now()->subYears($this->course->years_expires);

        if (! $this->course->lastResult) {
            return 'Not Taken';
        }

        if ($this->course->lastResult->passed && $this->course->lastResult->created_at > $expiryDate) {
            return 'passed';
        }

        if ($this->course->lastResult->passed && $this->course->lastResult->created_at < $expiryDate) {
            return 'expired';
        }

        if (! $this->course->lastResult->passed && $this->course->lastResult->created_at > $expiryDate) {
            return 'failed';
        }

        return 'Not Taken';
    }
}
