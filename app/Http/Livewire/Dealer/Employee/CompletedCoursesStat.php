<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Store;
use App\Traits\EmployeeCourseStatTrait;
use Livewire\Component;

class CompletedCoursesStat extends Component
{
    use EmployeeCourseStatTrait;

    public ?Store $store = null;

    public ?int $department = null;

    public string $name = '';

    public $readyToLoad = false;

    public $formattedName;

    public function mount(): void
    {
        $this->formattedName = str_replace(' ', '', $this->name);
        $this->formattedName = str_replace('/', '', $this->formattedName);
    }

    public function loadStat(): void
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $percentage = \Cache::remember('course_stat_' . $this->formattedName, now()->addDay(), function () {
            return $this->readyToLoad ? $this->percentageByDepartment($this->store, $this->department) : '';
        });
        return view('livewire.dealer.employee.completed-courses-stat', compact('percentage'));
    }
}
