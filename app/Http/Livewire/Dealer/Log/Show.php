<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Log;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Show extends Component
{
    public Activity $activity;

    public function render()
    {
        return view('livewire.dealer.log.show')->layout('components.dealer-app');
    }
}
