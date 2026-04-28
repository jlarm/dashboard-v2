<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Actions;

use App\Models\Dealer\Course;

class ToggleOptionalCourse
{
    public function handle(Course $course): void
    {
        $course->update(['optional' => ! $course->optional]);
    }
}
