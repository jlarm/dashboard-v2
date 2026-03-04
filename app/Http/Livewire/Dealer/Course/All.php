<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use Illuminate\View\View;
use Livewire\Component;

class All extends Component
{
    public function render(): View
    {
        $courses = Course::query()
            ->with([
                'results' => static function ($query): void {
                    $query
                        ->where('user_id', auth()->id())
                        ->latest('created_at');
                },
            ])
            ->get();

        return view('livewire.dealer.course.all', [
            'courses' => $courses,
        ]);
    }
}
