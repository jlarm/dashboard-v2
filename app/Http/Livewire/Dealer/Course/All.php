<?php

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\Course;
use Livewire\Component;

class All extends Component
{
    public function render()
    {
        return view('livewire.dealer.course.all', [
            'courses' => Course::all(),
        ]);
    }
}
