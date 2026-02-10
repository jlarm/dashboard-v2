<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public Course $course;
    public ?int $module1 = null;
    public ?int $module2 = null;
    public ?int $module3 = null;

    public function render(): View
    {
        return view('livewire.dealer.course.index-item');
    }
}
