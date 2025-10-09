<?php

namespace App\Http\Livewire\Tenant\Course;

use App\Models\Dealer\Course;
use App\Traits\HasCourseStatus;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    use HasCourseStatus;

    public Course $course;
    private array $dot = [
        'dot-hazardous-materials-transportation',
        'dot-hazardous-materials-transportation-identifying-hazardous-materials',
        'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment',
        'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding',
    ];

    public function dotProgress(): bool
    {
        $slug = $this->course->slug;
        $position = array_search($slug, $this->dot);

        if ($position !== 0) {
            return true;
        }

        return false;
    }

    public function render(): View
    {
        return view('livewire.tenant.course.index-item');
    }
}
