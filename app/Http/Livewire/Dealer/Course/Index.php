<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Course;

use App\Traits\EmployeeCourses;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    use EmployeeCourses;

    public ?int $module1 = null;
    public ?int $module2 = null;
    public ?int $module3 = null;

    public function mount(): void
    {
        $this->loadCoursesForCurrentUser();
        $this->loadModuleStatuses();
    }

    public function render(): View
    {
        return view('livewire.dealer.course.index', [
            'courses' => $this->courses,
        ]);
    }

    private function loadModuleStatuses(): void
    {
        $this->module1 = $this->getModuleStatus('dot-hazardous-materials-transportation');
        $this->module2 = $this->getModuleStatus('dot-hazardous-materials-transportation-identifying-hazardous-materials');
        $this->module3 = $this->getModuleStatus('dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment');
    }

    private function getModuleStatus(string $slug): ?int
    {
        if (! $this->courses) {
            return null;
        }

        $course = $this->courses->firstWhere('slug', $slug);
        if (! $course || $course->results->isEmpty()) {
            return null;
        }

        return $course->results->first()->passed;
    }
}
