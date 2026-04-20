<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\VideoProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VideoProgressController extends Controller
{
    public function store(Request $request, Course $course): RedirectResponse
    {
        $this->authorize('view', $course);

        abort_unless(is_string($course->video_id) && $course->video_id !== '', 404);

        /** @var User $user */
        $user = $request->user();

        VideoProgress::query()->create([
            'user_id' => $user->id,
            'video_id' => $course->video_id,
            'completed' => true,
        ]);

        return to_route('courses.show', $course);
    }
}
