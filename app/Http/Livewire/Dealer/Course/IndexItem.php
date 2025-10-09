<?php

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Component;

class IndexItem extends Component
{
    public User $user;
    public Course $course;
    public Store $store;
    public $module1;
    public $module2;
    public $module3;

    public function mount()
    {
        $this->user = auth()->user();

        if (tenant('locations')) {
            $this->store = $this->user->stores->first() ?? Store::first();
        } else {
            $this->store = Store::first();
        }

        $course1 = Course::with('results')->where('slug', 'dot-hazardous-materials-transportation')->pluck('id');
        $course2 = Course::with('results')->where('slug', 'dot-hazardous-materials-transportation-identifying-hazardous-materials')->pluck('id');
        $course3 = Course::with('results')->where('slug', 'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment')->pluck('id');

        $this->module1 = $this->user->results->whereIn('course_id', $course1)->pluck('passed')->last();
        $this->module2 = $this->user->results->whereIn('course_id', $course2)->pluck('passed')->last();
        $this->module3 = $this->user->results->whereIn('course_id', $course3)->pluck('passed')->last();

    }

    public function render()
    {
        return view('livewire.dealer.course.index-item');
    }
}
